<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private $urlGenerator;
    private $authorizationChecker;

    public function __construct(UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->urlGenerator = $urlGenerator;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'security_login'
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('login')['email'];
        $password = $request->request->get('login')['password'];

        $userBadge = new UserBadge($email);

        $credentials = new PasswordCredentials($password);

        return new Passport($userBadge, $credentials);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();
        return match (true) {
            $this->authorizationChecker->isGranted('ROLE_ADMIN', $user) => new RedirectResponse($this->urlGenerator->generate('app_admin')),
            $this->authorizationChecker->isGranted('ROLE_GNM', $user) => new RedirectResponse($this->urlGenerator->generate('dash_gnm')),
            $this->authorizationChecker->isGranted('ROLE_AGENT', $user) => new RedirectResponse($this->urlGenerator->generate('dash_agent')),
            $this->authorizationChecker->isGranted('ROLE_USER', $user) => new RedirectResponse($this->urlGenerator->generate('security_login')),
                // Ajoutez d'autres conditions pour les autres rôles
            default => new RedirectResponse($this->urlGenerator->generate('security_login')),
        };
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);
        $login = $request->request->get('login');
        $request->attributes->set(Security::LAST_USERNAME, $login['email']);
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        /*
             * If you would like this class to control what happens when an anonymous user accesses a
             * protected page (e.g. redirect to /login), uncomment this method and make this class
             * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
             *
             * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
             */
        return new RedirectResponse($this->urlGenerator->generate('security_login'));
    }
}
