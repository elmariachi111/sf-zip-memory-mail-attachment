<?php

namespace App\Command;

use Badcow\LoremIpsum\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZipStream\ZipStream;

class SendMailCommand extends Command
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        parent::__construct('mailer');
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('send:mail');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memoryStream = fopen('php://memory', 'w+b');
        $arch = new ZipStream(null, [
            ZipStream::OPTION_OUTPUT_STREAM => $memoryStream
        ]);

        $arch->addFile("lorem-ipsum.txt", $this->getText());
        $arch->addFile("image.jpg", $this->getImage());

        $arch->finish();

        rewind($memoryStream);
        $data = stream_get_contents($memoryStream);

        $attachment = new \Swift_Attachment($data, 'attachmemt.zip', 'application/zip');
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('from@example.com')
            ->setTo('address@example.com')
            ->setBody('Hello')
            ->attach($attachment);
        ;

        $this->mailer->send($message);
    }

    private function getText() {
        $lorem = new Generator();
        return implode("\n", $lorem->getParagraphs(100));
    }

    private function getImage() {
        return file_get_contents("Resources/octocat.png");
    }
}