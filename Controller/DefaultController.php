<?php

/**
 * Copyright (c) 2014, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Controller;

use Core\BaseBundle\Controller\GridDefaultController;
use Symfony\Component\HttpFoundation\Request;
use TMSolution\DataGridBundle\Grid\Source\Entity;
use TMSolution\DataGridBundle\Grid\Action\RowAction;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Core\SecurityBundle\Annotations\Permissions;

/**
 * Kontroler kanału 'app', 'edi'.
 * 
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */
class DefaultController extends GridDefaultController
{

    /**
     * Przesłonięte szablony.
     * 
     * @var array
     */
    protected $templates = [
        'read' => 'CoreBaseBundle:Default:grid.html.twig',
        'ajax_read' => 'CoreBaseBundle:Default:solidgrid.html.twig',
        'show' => 'TMSolutionLoggingBundle:Default:show.html.twig',
        'notfound' => 'TMSolutionLoggingBundle:Default:notfound.html.twig',
        'create' => 'CoreBaseBundle:Default:new.html.twig',
    ];

    /**
     * Kontroler kanału 'app'.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entityName
     * @return Response

     * @Permissions(rights={MaskBuilder::MASK_VIEW})
     */
    public function readChannelAppAction(Request $request, $entityName = 'log')
    {

        //$model = $this->getModel($this->getEntityClass($entityName, $request->getLocale()));
        $model = $this->getDefaultModel();
        $source = new Entity($model);
        $businessQueryBuilder = $model->getChannelQuery('app');
        $source->initQueryBuilder($businessQueryBuilder);
        $grid = $this->get('grid');
        $grid->setSource($source);
        
        $grid->getColumn('message')->setTitle('Komunikat Systemowy');
        $grid->getColumn('id')->setTitle('Id');
        $grid->setNumberPresentedFilterColumn(3);
        $grid->setHideFilters(['id', 'level', 'channel', 'message']);
        $grid->setDefaultOrder('id', 'desc');
        $grid->getColumn('viewed')->setFilterType('select');

       

        $rowAction1 = new RowAction('clip-eye', 'logging_default_show', false, null, array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => 'Podgląd'));
        $this->setGridActionRouteParameters($rowAction1);
        //$grid->addRowAction($rowAction1);
        $grid->setVisibleColumns(['id', 'dateTime', 'levelName', 'message']);
        $grid->setColumnsOrder(['id', 'dateTime', 'levelName', 'message']);
        $grid->getColumn('dateTime')->setFilterType('datepicker');
        
       if ($this->getRequest()->isXmlHttpRequest()) {
            $view = $this->templates['ajax_read'];
        } else {

            $grid->resetSessionData();             $view = $this->templates['read'];
        }

        return $grid->getGridResponse($view, array(
                    'panelName' => 'Dziennik aplikacji'
        ));
    }

    /**
     * Kontroler kanału 'edi'.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entityName
     * @return Response
     * @Permissions(rights={MaskBuilder::MASK_VIEW})
     */
    public function readChannelEdiAction(Request $request, $entityName = 'edilog')
    {


        $model = $this->getModel($this->getEntityClass($entityName, $request->getLocale()));
        //$model = $this->getDefaultModel();
        $source = new Entity($model);
        $businessQueryBuilder = $model->getChannelQuery('edi');
        $source->initQueryBuilder($businessQueryBuilder);
        $grid = $this->get('grid');
        $grid->setSource($source);
        $grid->getColumn('id')->setTitle('Id');
        $grid->getColumn('message')->setTitle('Komunikat Systemowy');
        $grid->setNumberPresentedFilterColumn(3);
        $grid->setHideFilters(['id', 'level', 'channel', 'message','viewed','userId.name' , 'levelName']);
        $grid->setDefaultOrder('id', 'desc');
        $grid->getColumn('viewed')->setFilterType('select');
        $grid->getColumn('levelName')->setFilterType('select');
        $rowAction1 = new RowAction('clip-eye', 'logging_default_show', false, null, array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => 'Podgląd'));
        $this->setGridActionRouteParameters($rowAction1);
        //$grid->addRowAction($rowAction1);
        $grid->setVisibleColumns([/*'id',*/ 'dateTime', 'levelName', 'message']);
        $grid->setColumnsOrder(['id', 'dateTime', 'levelName', 'message']);
        $grid->getColumn('dateTime')->setFilterType('datepicker');
        
         $grid->getColumn('dateTime')->manipulateRenderCell(function ($value, $row) {

            return $row->getField('dateTime')->format('Y-m-d H:i:s');
        });
        
   
         if ($this->getRequest()->isXmlHttpRequest()) {
            $view = $this->templates['ajax_read'];
        } else {

            $grid->resetSessionData();             $view = $this->templates['read'];
        }

        return $grid->getGridResponse($view, array(
                    'panelName' => 'Dziennik logów EDI'
        ));
    }

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entityName
     * @param string $id
     * @return Response
     * @Permissions(rights={MaskBuilder::MASK_VIEW})
     */
    public function show($id)
    {

        $entity = $this->getDefaultModel()->findOneById($id);
        if ($entity == null) {
            return $this->render($this->templates['notfound']);
        }
        if ($entity->getViewed() === false) {
            $entity->setViewed(true);
            $model->flush();
        }
        return $this->render($this->templates['show'], array(
                    'entity' => $entity,
        ));
    }

    /**
     * Dodaje fake record.
     * 
     * @todo Usunąć metodę
     * @return Response
     * @Permissions(rights={MaskBuilder::MASK_VIEW})
     */
    public function indexAction()
    {

        $logManager = $this->get('TMSolution.Logging.LogManager');
        $logger = $logManager->getLogger('app');
        $logger->info("This is a info message", ["extended" => "Extended debug info"]);
        $logger->warning("This is a warning message", ["extended" => "Extended debug info"]);
        $logger->error("This is a error message", ["extended" => "Extended debug info"]);
        $logger->alert("This is a alert message", ["extended" => "Extended debug info"]);
        $ediLogger = $logManager->getLogger('edi');
        $ediLogger->info("This is a info message");
        $ediLogger->warning("This is a warning message", ["extended" => "Extended debug info"]);
        $ediLogger->error("This is a error message");
        $ediLogger->alert("This is a alert message");
        return $this->render('TMSolutionLoggingBundle:Default:index.html.twig', array('name' => "Logging"));
    }

    /**
     * @Permissions(rights={MaskBuilder::MASK_VIEW})
     */
    public function newAction()
    {

        $entity = $this->getDefaultModel()->getEntity();
        $formType = $this->getFormType($objectName, null);
        $form = $this->makeForm($formType, $entity, 'POST', $this->getEntityName(), $this->getAction('create'));
        return $this->render($this->templates['create'], array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'entityName' => $entityName,
                    'readActionName' => $this->getAction('read')
        ));
    }

    /**
     * Zwraca etykietę ostatniego rutingu.
     * 
     * @return string
     * @Permissions(rights={MaskBuilder::MASK_VIEW})
     */
    private function getRefererRoute()
    {

        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $lastPath = substr($referer, strpos($referer, $request->getBaseUrl()));
        $lastPath = str_replace($request->getBaseUrl(), '', $lastPath);
        $matcher = $this->get('router')->getMatcher();
        $parameters = $matcher->match($lastPath);
        $route = $parameters['_route'];
        return $route;
    }

}
