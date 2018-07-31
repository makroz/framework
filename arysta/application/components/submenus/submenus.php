<?php
namespace  Components\Submenus
{
class Submenus extends \Mk\Component
{
    public function __construct($campos = array(), $variables=array(), $options=array())
    {
        parent::__construct($campos, $variables, $options);
    }

    public function get()
    {
        $db=\Mk\Registry::get('database');
        $result=$db->query()->all("select pk,nom, link,tipo,contenido, fk_menus from submenus where (status=1) order by fk_menus, posi");
        return $result;
    }
}
}
