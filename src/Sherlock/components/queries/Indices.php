<?php
/**
 * User: Zachary Tong
 * Date: 2013-02-16
 * Time: 09:24 PM
 * Auto-generated by "generate.php"
 * @package Sherlock\components\queries
 */
namespace Sherlock\components\queries;

use Sherlock\components;

/**
 * @method \Sherlock\components\queries\Indices no_match_query() no_match_query(\sherlock\components\QueryInterface $value)
 * @method \Sherlock\components\queries\Indices query() query(\sherlock\components\QueryInterface $value)
 */
class Indices extends \Sherlock\components\BaseComponent implements \Sherlock\components\QueryInterface
{
    public function __construct($hashMap = null)
    {

        parent::__construct($hashMap);
    }


    /**
     * @param  array | string $indices,...
     *
     * @return Indices
     */
    public function indices($indices)
    {
        $args = func_get_args();
        \Analog\Analog::log("Indicies->Indices(" . print_r($args, true) . ")", \Analog\Analog::DEBUG);

        //single param, array of strings
        if (count($args) == 1 && is_array($args[0])) {
            $args = $args[0];
        }

        foreach ($args as $arg) {
            if (is_string($arg)) {
                $this->params['indices'][] = $arg;
            }
        }

        return $this;
    }


    public function toArray()
    {
        $ret = array(
            'indices' =>
            array(
                'indices'        => $this->params["indices"],
                'query'          => $this->params["query"]->toArray(),
                'no_match_query' => $this->params["no_match_query"]->toArray(),
            ),
        );

        return $ret;
    }

}
