<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use function Symfony\Component\String\u;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;



/**
 * Class CreateTableSessionCommand
 */
class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $entityManager;
    private $passwordHasher;
    private $users;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, UserRepository $users)
    {
        parent::__construct();
        $this->entityManager = $em;
        $this->passwordHasher = $passwordHasher;
        $this->users = $users;
    }

    protected function configure(): void
    {
        $this->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the name of user : ');
        $question->setValidator(function ($answer) {
            if (!is_string($answer) || trim($answer) == '') {
                throw new \RuntimeException('The name must be not null');
            }

            if (1 !== preg_match('/^[a-z_]+$/', $answer)) {
                throw new \RuntimeException('The username must contain only lowercase latin characters and underscores.');
            }

            $existingUser = $this->users->findOneBy(['username' => $answer]);
            if (null !== $existingUser) {
                throw new \RuntimeException('There is already a user registered');
            }
    
            return $answer;
        });
        $question->setMaxAttempts(3);
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the password for '.$name.' : ');
        $question->setValidator(function ($answer) {
            $answer = trim($answer);
            if (empty($answer)) {
                throw new \Exception('The password cannot be empty');
            }

            if (u($answer)->length() < 6) {
                throw new \Exception('The password must be at least 6 characters long.' );
            }
    
            return $answer;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(3);
        $password = $helper->ask($input, $output, $question);

        $question = new ChoiceQuestion('Is Admin ? (defaults to false)',
            ['false', 'true'],
            0
        );

        $isAdmin = $helper->ask($input, $output, $question);

        $user = new User();
        $user->setUsername($name);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        if ($isAdmin == 'true') {
            $user->setRoles(['ROLE_ADMIN']);
        } else {
            $user->setRoles(['ROLE_USER']);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}