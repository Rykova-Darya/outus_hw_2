<?php

namespace App\Command;

use App\Services\LuckyTicketService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'is:lucky-ticket',
    description: 'Проверяет верность вычисления количества 2N-значных счастливых билетов',
)]
class LuckyTicketsCommand extends Command
{
    public function __construct(private readonly LuckyTicketService $luckyTicketService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filename', InputArgument::REQUIRED, 'Название файла без расширения');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $filename = $input->getArgument('filename');
        $inputFilePath = $_ENV['TIKETS'] . $filename . '.in';
        $outputFilePath = $_ENV['TIKETS'] . $filename . '.out';

        if (!file_exists($inputFilePath) || !file_exists($outputFilePath)) {
            $output->writeln('<error>Один или оба файлы не найдены</error>');
            return Command::FAILURE;
        }

        $n = (int) fgets(fopen($inputFilePath, 'r'));
        $result = (int) fgets(fopen($outputFilePath, 'r'));

        fclose(fopen($inputFilePath, 'r'));
        fclose(fopen($outputFilePath, 'r'));

        $isLuckyTicket = $this->luckyTicketService->isLuckyTicket($n, $result, $filename);
        $output->writeln('<info>' . $isLuckyTicket . '</info>');
        return Command::SUCCESS;
    }
}
