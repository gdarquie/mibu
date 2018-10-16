<?php

namespace App\Security;

use App\Entity\Concept\Inscrit;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class JwtTokenAuthenticator extends AbstractFormLoginAuthenticator
{
    private $jwtEncoder;
    private $passwordEncoder;
    private $em;
    private $router;

    /**
     * JwtTokenAuthenticator constructor.
     * @param JWTEncoderInterface $jwtEncoder
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RouterInterface $router
     */
    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, RouterInterface $router)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        if($request->attributes->get('_route') === 'accueil') {
            return false;
        }
        else if($request->attributes->get('_route') === 'post_jeton') {
            return false;
        }
        else if($request->attributes->get('_route') === 'post_inscrit') {
            return false;
        }
        return true;
//        return $request->attributes->get('_route') !== 'post_jeton';
    }

    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($request);

        if (!$token) {
            return;
        }

        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $data = $this->jwtEncoder->decode($credentials);
        } catch (JWTDecodeFailureException $e) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }
        
        return $this->em
            ->getRepository(Inscrit::class)
            ->findOneBy(['pseudo' => $data['pseudo']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return JsonResponse|RedirectResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'error' => 'auth required'
        ], 401);
    }

}
