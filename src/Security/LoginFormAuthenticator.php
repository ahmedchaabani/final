<?php

namespace App\Security;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;
    private UserRepository $userRepository;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    

    public function authenticate(Request $request): Passport
    {
        
        $email = $request->getPayload()->getString('email');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);
    // Récupérer l'utilisateur depuis la base de données
    $userBadge = new UserBadge($email, function ($userIdentifier) {
        return $this->userRepository->findOneBy(['email' => $userIdentifier]);
    });

    // Vérifier si l'utilisateur est vérifié
    $user = $this->userRepository->findOneBy(['email' => $email]);

    /*if (!$user || !$user->isVerified()) {
        throw new \Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException(
            'Votre compte n\'est pas encore vérifié.'
        );
    }*/
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        $user = $token->getUser();

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        if(in_array('ROLE_ADMIN',$user->getRoles(),true)) {
            return new RedirectResponse($this->urlGenerator->generate('app_dash'));
        }
        
        return new RedirectResponse($this->urlGenerator->generate('index2'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
