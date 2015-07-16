<?php

/**
 * Copyright (c) 2013, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Model;

    use Core\BaseBundle\Model\Model;
    use InvalidArgumentException;

    /**
     * LogRecord.
     * 
     * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
     */
    class LogRecord extends Model {

        /**
         * Zwraca model wybranego kanału dziennika np. 'edi', 'app'.
         * 
         * @return \Doctrine\ORM\QueryBuilder
         */
        public function getChannelQuery($channel) {

            if (func_num_args() == 0) {
                throw new InvalidArgumentException("No arguments");
            }
            if (is_string($channel) == false || $channel == "") {
                throw new InvalidArgumentException(
                "Invalid or empty channel name");
            }
            $this->checkRight(self::VIEW);
            $repository = $this->getRepository();
            return $repository->createQueryBuilder('u')->where("u.channel = '{$channel}'");
        }
        
        /**
         * Odznacza rekord dziennika, jako przeczytany.
         * 
         */
        public function updateView($objectName, $id) {
            
            $this->checkRight(parent::UPDATE);
            $entity = $this->manager->getRepository('TMSolutionLoggingBundle:LogRecord')->find($id);
            if ($entity == null) {
                throw $this->createNotFoundException(
                        'Unable to find '.$this->className.' entity.');
            }
            $entity->setViewed(1);
            $em->flush();
            
        }

    }
