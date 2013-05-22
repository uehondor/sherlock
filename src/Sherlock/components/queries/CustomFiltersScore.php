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
 * @method \Sherlock\components\queries\CustomFiltersScore query() query(\sherlock\components\QueryInterface $value)
 * @method \Sherlock\components\queries\CustomFiltersScore score_mode() score_mode(\string $value) Default: "first"
 * @method \Sherlock\components\queries\CustomFiltersScore max_boost() max_boost(\float $value) Default: 10

 */
class CustomFiltersScore extends \Sherlock\components\BaseComponent implements \Sherlock\components\QueryInterface
{
    public function __construct($hashMap = null)
    {
        $this->params['score_mode'] = "first";
        $this->params['max_boost']  = 10;

        parent::__construct($hashMap);
    }


    /**
     * @param  \Sherlock\components\FilterInterface | array $filter,... - one or more Filters can be specified individually, or an array of filters
     *
     * @return CustomFiltersScore
     */
    public function filters($filter)
    {

        $args = func_get_args();
        \Analog\Analog::log("CustomFiltersScore->Filters(" . print_r($args, true) . ")", \Analog\Analog::DEBUG);

        //single param, array of filters
        if (count($args) == 1 && is_array($args[0])) {
            $args = $args[0];
        }

        foreach ($args as $arg) {
            if ($arg instanceof \Sherlock\components\FilterInterface) {
                $this->params['filters'][] = $arg->toArray();
            }
        }

        return $this;
    }


    public function toArray()
    {
        $filters = array();
        foreach ($this->params['filters'] as $filter) {
            $filters[] = array("filter" => $filter);
        }

        $ret = array(
            'custom_filters_score' =>
            array(
                'query'      => $this->params["query"]->toArray(),
                'filters'    => $filters,
                'score_mode' => $this->params["score_mode"],
                'max_boost'  => $this->params["max_boost"],
            ),
        );

        return $ret;
    }

}
