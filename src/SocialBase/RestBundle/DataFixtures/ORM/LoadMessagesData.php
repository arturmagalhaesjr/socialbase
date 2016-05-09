<?php
/**
 *
 * Esta Classe faz parte do sistema cms.web
 * (c)  Artur Magalhães <nezkal@gmail.com>
 * Para maiores informações visite o site www.tritoq.com
 *
 * @author Artur Magalhães <nezkal@gmail.com>
 */


namespace SocialBase\RestBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use joshtronic\LoremIpsum;
use SocialBase\RestBundle\Entity\Messages;

/**
 *
 * Data Fixture to messages
 *
 *
 * @category  Library
 * @copyright Artur Magalhães <nezkal@gmail.com>
 * @package   SocialBase\RestBundle\DataFixtures\ORM
 * @license   GPL-3.0+
 */
class LoadMessagesData extends AbstractFixture
{
    /**
     *
     * Loads the data
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lipsum = new LoremIpsum();

        // TODO: Implement load() method.
        for ($i = 0; $i < 100; $i++) {
            $message = new Messages();
            $message
                ->setDatetime(new \DateTime('now'))
                ->setIp(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null)
                ->setMessage(substr($lipsum->words(rand(3,6)), 0, 140));

            $manager->persist($message);
        }

        $manager->flush();
    }
}