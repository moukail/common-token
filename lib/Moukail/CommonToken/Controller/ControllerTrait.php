<?php

namespace Moukail\CommonToken\Controller;

use Moukail\CommonToken\Entity\TokenInterface;
use Moukail\CommonToken\Exception\InvalidEmailException;
use Moukail\CommonToken\Exception\InvalidTokenException;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

trait ControllerTrait
{
    private function emailValidation($request, $validator): string
    {
        $email = $request->get('email');

        if (empty($email)) {
            /** @var string $content */
            $content = $request->getContent();

            /** @var array $data */
            $data = json_decode($content, true);
            $email = $data['email'];
        }

        $emailConstraint = new Assert\Email();
        $emailConstraint->message = 'Invalid email address';

        $email_errors = $validator->validate($email, $emailConstraint);

        if (0 < count($email_errors)) {
            return $this->json([
                'status' => 'error',
                'errors' => [ 'email' => 'Email not valid'],
            ], Response::HTTP_BAD_REQUEST);
        }

        return $email;
    }

    /**
     * @param string $email
     * @return TokenInterface
     * @throws InvalidTokenException
     */
    private function generateTokenEntity(string $email): TokenInterface
    {
        $user = $this->userRepository->findOneBy([
            'email' => $email,
        ]);

        if (!$user) {
            throw new InvalidEmailException();
        }

        return $this->helper->generateTokenEntity($user);
    }
}
