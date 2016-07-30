<?php

namespace SocialBase\RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use SocialBase\RestBundle\Entity\Messages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

/**
 *
 * Rest Controller of messages
 *
 *
 * @category  Library
 * @copyright Artur Magalhães <nezkal@gmail.com>
 * @package   SocialBase\RestBundle\Controller
 * @license   GPL-3.0+
 */
class MessagesController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMessagesAction(Request $request)
    {
        $manager = $this->get('doctrine.orm.entity_manager');

        $limit = (int)$request->get('limit', 20);

        if (intval($limit) <= 0) {
            $limit = 20;
        }

        $data = $manager->getRepository('SocialBaseRestBundle:Messages')
            ->createQueryBuilder('m')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $view = $this->view($data);

        $view->setTemplate('SocialBaseRestBundle:Messages:show.html.twig')
            ->setTemplateVar('messages');


        return $this->handleView($view);
    }


    public function getMessageAction($id)
    {
        $manager = $this->get('doctrine.orm.entity_manager');
        $object = $manager->getRepository('SocialBaseRestBundle:Messages')->find($id);

        if (!$object) {
            throw $this->createNotFoundException('The ' . $id . ' not found');
        }

        $view = $this->view($object)
            ->setTemplate('SocialBaseRestBundle:Messages:item.html.twig')
            ->setTemplateVar('message');

        return $this->handleView($view);

    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postMessagesAction(Request $request)
    {
        $message = $request->get('message');

        $object = new Messages();
        $object
            ->setMessage($message)
            ->setIp(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null)
            ->setDatetime(new \DateTime('now'));

        $validator = $this->get('validator');
        $errors = $validator->validate($object);

        if (count($errors) === 0) {
            $manager = $this->get('doctrine.orm.entity_manager');

            $manager->persist($object);
            $manager->flush();

            return $this->handleView($this->view($object));
        }

        throw new InvalidArgumentException('The message has invalid {' . ((string)$errors) . '}');
    }

    /**
     *
     *
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putMessageAction(Request $request, $id)
    {
        $manager = $this->get('doctrine.orm.entity_manager');
        $object = $manager->getRepository('SocialBaseRestBundle:Messages')->find($id);

        if (!$object) {
            throw $this->createNotFoundException('The ' . $id . ' not found');
        }

        $message = $request->get('message');
        $object->setMessage($message);

        $validator = $this->get('validator');
        $errors = $validator->validate($object);

        if (count($errors) === 0) {
            $manager->persist($object);
            $manager->flush();

            return $this->handleView($this->view($object));
        }
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteMessageAction($id)
    {
        $manager = $this->get('doctrine.orm.entity_manager');
        $object = $manager->getRepository('SocialBaseRestBundle:Messages')->find($id);

        if (!$object) {
            throw $this->createNotFoundException('The ' . $id . ' not found');
        }

        $manager->remove($object);
        $manager->flush();

        return $this->handleView($this->view($id));
    }

    public function optionsMessageAction ($id) {
        return new \Symfony\Component\HttpFoundation\Response("OK");
    }

}