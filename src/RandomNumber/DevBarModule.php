<?php
namespace RandomNumber;

use Zend\View\Model\ViewModel;
use DevBar\Listener\AbstractDevBarModule;

class DevBarModule extends AbstractDevBarModule
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

