<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Supports\Readable;

/**
 * Class ConfigItems
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="配置管理",
 *     name="#"
 * )
 */
class ConfigItems extends Readable{

    /**
     * @FieldAttribute(
     *     label="站点名称",
     *     name="ONECMS_TITLE",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_TITLE;
    

    /**
     * @FieldAttribute(
     *     label="站点关键词",
     *     name="ONECMS_KEYWORD",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_KEYWORD;
    

    /**
     * @FieldAttribute(
     *     label="站点描述",
     *     name="ONECMS_DESC",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_DESC;
    

    /**
     * @FieldAttribute(
     *     label="版权信息",
     *     name="ONECMS_COPYRIGHT",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_COPYRIGHT;
    

    /**
     * @FieldAttribute(
     *     label="邮箱",
     *     name="ONECMS_EMAIL",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_EMAIL;
    

    /**
     * @FieldAttribute(
     *     label="站点logo",
     *     name="ONECMS_LOGO",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_LOGO;
    

    /**
     * @FieldAttribute(
     *     label="站点流量统计",
     *     name="ONECMS_TONGJI",
     *     ableTo=15,
     *     inputType="text"
     * )
     */
    public $ONECMS_TONGJI;
    

}