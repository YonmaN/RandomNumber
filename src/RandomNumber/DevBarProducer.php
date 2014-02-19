<?php
namespace RandomNumber;

use Zend\View\Model\ViewModel;
use DevBar\Listener\AbstractDevBarProducer;

class DevBarProducer extends AbstractDevBarProducer
{
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function __invoke() {
        $randomNumber = new RandomNumber();
        $viewModel = new ViewModel(array('randomnumber' => $randomNumber->random()));
        $viewModel->setTemplate('random/randomnumber');
        return $viewModel;
    }
}

