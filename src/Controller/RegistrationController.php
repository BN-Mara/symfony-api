<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/auth', name: 'auth_')]
class RegistrationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em,
     private UserPasswordHasherInterface $ph, private JWTTokenManagerInterface $jwtManager, 
     private AuthenticationSuccessHandler $authHandler, private MailerInterface $mailer){
       

    }
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request): Response 
    {
        //$authenticationSuccessHandler = $this->container->get('lexik_jwt_authentication.handler.authentication_success');
        //$jwtManager = $this->container->get('lexik_jwt_authentication.handler.authentication_success');
        $decoded = json_decode($request->getContent());
        $username = $decoded->username;
        $plaintextPassword = $decoded->password;
        $roles = $decoded->roles;
        $phone = $decoded->phone;
        $address = $decoded->address;
        //$email = $decoded->email;
        $fullname = $decoded->fullname;

        $ck_user=$this->em->getRepository(User::class)->findOneBy(["username"=>$username]);
        if($ck_user){
            return $this->json(["success"=>"false","message"=>"Cet utilisateur ($username) est déjà pris"],400);
        }

  
        $user = new User();
        $hashedPassword = $this->ph->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setUsername($username);
        $user->setRoles($roles);
        $user->setFullname($fullname);
        $user->setPhone($phone);
        $user->setAddress($address);
        $user->setIsActive(true);
        $this->em->persist($user);
        $this->em->flush();
        
            
            // ...
        
        $auth = $this->authHandler->handleAuthenticationSuccess($user);

        //$token = $this->jwtManager->create($user);
        $authContent = json_decode($auth->getContent());
  
        return $this->json(['success'=>true,
        'message' => 'Enregistré avec succès',
        'sub'=>$user->getId(),
        'username'=>$user->getUsername(),
    'fullname' => $user->getFullname(),
    'phone' => $user->getPhone(),
    'isActive' => $user->isIsActive(),
    'address' => $user->getAddress(),
        //'token'=>$token
        "token"=>$authContent->token,
        "refresh_token"=>$authContent->refresh_token,
        
    ]);
    }

    #[Route(path:"/mail",name:"app_mailer", methods:"POST")]
    public function sendMail(Request $request):Response
    {
        $params = json_decode($request->getContent());
        $message = $params->message;
        $to = $params->to;
        $object = $params->object;
        try {
            //code...
            $email = (new Email())
                ->from('noreply@maajabutalent.com')
                ->to($to)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject($object)
                ->text('Sending emails is fun again!')
                ->html($message);
    
            $rs = $this->mailer->send($email);
            return $this->json(['message'=>"Mail sent successfully"],200);
    
        } catch (\Throwable $th) {
            //throw $th;
            return $this->json(['code'=>$th->getCode(), 'message'=>$th->getMessage()],500);

        }

    }

    
    
}
