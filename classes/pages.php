<?php
/**
*   -D- @pages - Класс "сборщика страниц" (Page Controller);
*/
class pages
{
    /**
    *   -D- @getTemplate - Метод подключения шаблона с передачей ему необходимых для отображения страницы параметров;
    */
    public function getTemplate($file, $vars=array())
    {
        include($file);
    }
    /**
     *
     *
     */
    private function index()
    {
        $this->getTemplate('templates/header.tpl',
            array(
                'title'=>'Оформление заявок на кредиты и вклады'
            )
        );
        $this->getTemplate('templates/main.tpl',
            array(
                'errorMessages' => $result['errors'],
            )
        );
        $this->getTemplate('templates/footer.tpl');
    }
    /**
     *
     *
     */
    private function getCreditPage()
    {
        $this->getTemplate('templates/header.tpl',
            array(
                'title'=>'Заявка на кредит'
            )
        );
        $this->getTemplate('templates/get_credit.tpl',
            array(
                'errorMessages' => $result['errors'],
            )
        );
        $this->getTemplate('templates/footer.tpl');
    }
    /**
     *
     *
     */
    private function getDepositPage()
    {
        $this->getTemplate('templates/header.tpl',
            array(
                'title'=>'Заявка на вклад'
            )
        );
        $this->getTemplate('templates/get_deposite.tpl',
            array(
                'errorMessages' => $result['errors'],
            )
        );
        $this->getTemplate('templates/footer.tpl');
    }
    /**
     *   -D- @router - Основной метод задающий "маршрут" приложения для генерации соответствующей страницы;
     *
     */
    public function router($page)
    {
        /**
        *   -D- Выбор метода для генерации нужной страницы;
        */
        switch ($page)
        {
            case 'get_credit':
                $this->getCreditPage();
                break;
            case 'get_deposit':
                $this->getDepositPage();
                break;
            default:
                $this->index();
        }
    }
}