<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticatorInterface;
use Endroid\QrCode\QrCode;
use Symfony\Component\Routing\Attribute\Route;
use OTPHP\TOTP;
use Endroid\QrCode\Writer\PngWriter;
use Scheb\TwoFactorBundle\Model\Totp\TwoFactorInterface;
use Symfony\Component\HttpFoundation\Response;

final class TwoFactorController extends AbstractController
{
    #[Route('/aquadia/2fa/enable', name: 'app_2fa_enable')]
    public function enable2fa(TotpAuthenticatorInterface $totpAuthenticator, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isTotpAuthenticationEnabled()) {
            $user->setTotpSecret($totpAuthenticator->generateSecret());
            $em->flush();
        }

        /** @var TOTP $totp */
        $totp = TOTP::create(
            $user->getTotpSecret(),
            30,
            'sha1',
            6
        );

        $totp->setLabel($user->getEmail());
        $totp->setIssuer('Aquadia');

        return $this->render('2fa/enable.html.twig', [
            'secret' => $user->getTotpSecret(),
        ]);
    }


    #[Route('/aquadia/2fa/qr-code', name: 'app_qr_code')]
    public function displayGoogleAuthenticatorQrCode(TotpAuthenticatorInterface $totpAuthenticator): Response
    {
        $qrCodeContent = $totpAuthenticator->getQRContent($this->getUserTwoFactor());
        $qrCode = new QrCode($qrCodeContent);

        // Obligatoire en v3.x : passer par un writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return new Response(
            $result->getString(), // <-- vrai PNG généré
            200,
            ['Content-Type' => 'image/png']
        );
    }

    private function getUserTwoFactor(): TwoFactorInterface
    {
        $user = $this->getUser();
        if (!$user instanceof TwoFactorInterface) {
            throw new \LogicException('The logged-in user does not support two-factor authentication.');
        }
        return $user;
    }
}
