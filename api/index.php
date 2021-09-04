<?php

namespace pcb\api;

require_once '../vendor/autoload.php';
require_once './config/api_routes.php';

use pcb\api\category\ApiCategory;
use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$body = file_get_contents('php://input');

/**
 * Если в url не были переданы параметры request
 */
if ((!isset($_GET['request']) || empty($_GET['request']))) {
    exit();
}

switch ($_GET['request']) {
    /**
     * http://host.name/api/index.php?request=get_catalog_item_list
     */

    case GET_CATALOG_ITEM_LIST:
        $api = new ApiCatalogItem();
        echo $api->getJsonCatalogItemList();
        break;

    /**
     * http://host.name/api/index.php?request=get_catalog_item&id=[item_id]
     */

    case GET_CATALOG_ITEM:
        /**
         * Если id Catalog Item пустая или вовсе не существует
         */
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            exit();
        }

        $api = new ApiCatalogItem();
        echo $api->getJsonSingleItem((int)$_GET['id']);
        break;

    /**
     * http://host.name/api/index.php?request=create_catalog_item
     */

    case CREATE_CATALOG_ITEM:
        if (empty($body)) {
            exit();
        }

        $api = new ApiCatalogItem();
        echo $api->setJsonSingleItem($body);
        break;

    /**
     * http://host.name/api/index.php?request=update_catalog_item
     */

    case UPDATE_CATALOG_ITEM:
        if (empty($body)) {
            exit();
        }

        $api = new ApiCatalogItem();
        echo $api->updateJsonSingleItem($body);
        break;

    /**
     * http://host.name/api/index.php?request=delete_catalog_item
     */

    case DELETE_CATALOG_ITEM:
        if (empty($body)) {
            exit();
        }

        $api = new ApiCatalogItem();
        echo $api->deleteJsonSingleItem($body);
        break;

    /**
     * http://host.name/api/index.php?request=get_category_list
     */

    case GET_CATEGORY_LIST:
        $api = new ApiCategory();
        echo $api->getJsonCategoryList();
        break;

    /**
     * http://host.name/api/index.php?request=get_category&id=[category_id]
     */

    case GET_CATEGORY:
        /**
         * Если id Category пустая или вовсе не существует
         */
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            exit();
        }

        $api = new ApiCategory();
        echo $api->getJsonSingleCategory((int)$_GET['id']);
        break;

    /**
     * http://host.name/api/index.php?request=create_category
     */

    case CREATE_CATEGORY:
        if (empty($body)) {
            exit();
        }

        $api = new ApiCategory();
        echo $api->setJsonCategory($body);
        break;

    /**
     * http://host.name/api/index.php?request=update_category
     */

    case UPDATE_CATEGORY:
        if (empty($body)) {
            exit();
        }

        $api = new ApiCategory();
        echo $api->updateJsonCategory($body);
        break;

    /**
     * http://host.name/api/index.php?request=delete_category
     */

    case DELETE_CATEGORY:
        if (empty($body)) {
            exit();
        }

        $api = new ApiCategory();
        echo $api->deleteJsonCategory($body);
        break;

    default:
        exit();
}




