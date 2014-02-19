<?php
namespace RandomNumber;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;

class DevBarModule implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /* (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents      = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach('devbar', 'DevBarModules', array($this, 'produceViewModel'), 100);
    }

    /* (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::detach()
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function produceViewModel() {
        $randomNumber = new RandomNumber();
        $viewModel = new ViewModel(array('randomnumber' => $randomNumber->random()));
        $viewModel->setTemplate('random/randomnumber');
        return $viewModel;
    }
}

