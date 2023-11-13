<?php

namespace Tm\OrangeMoneyBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tm\OrangeMoneyBundle\Entity\Custumer;
use Tm\OrangeMoneyBundle\Http\Api\PublicKeyService;
use Tm\OrangeMoneyBundle\Http\Api\SandBox\GetOTPService;

#[AsCommand(name: 'tm:om:otp',description: 'Fetch OTP to the sandbox API',)]
class OTPCommand extends Command
{
    public function __construct(
        private PublicKeyService $publicKeyService,
        private GetOTPService $OTPService
    ){parent::__construct();}

    protected function configure(): void
    {
        $this
            ->addArgument('msisdn', InputArgument::OPTIONAL, 'Customer MSISDN')
            ->addArgument('pin', InputArgument::OPTIONAL, 'Customer Code pin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $msisdn = $input->getArgument('msisdn');
        $pin = $input->getArgument('pin');

        if (!$msisdn) {
            $msisdn = $io->ask("Please enter your Custumer msisdn : ");
        }
        if (!$pin) {
            $pin = $io->ask("Please enter your Custumer pin : ");
        }
        if (!$this->validateInput($msisdn, $pin)){
            $io->error('Your input is invalid');
            return Command::FAILURE;
        }

        $omKey = $this->publicKeyService->__invoke();
        $customer = new Custumer($msisdn);
        //TODO: Make the code works

        return Command::SUCCESS;
    }

    private function validateInput(string $msisdn, string $pin): bool
    {
        return preg_match("/^\d{4}$/", $pin) && preg_match("/^7\d{8}$/", $msisdn);
    }
}
