<?php

namespace Marshmallow\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Marshmallow\Product\Models\Product;
use Marshmallow\Feeds\GoogleShopping\Feed;
use Marshmallow\Feeds\GoogleShopping\FeedProduct;
use Marshmallow\Feeds\GoogleShopping\FeedProduct\Shipping;

class ProductFeedController extends Controller
{
    public function google()
    {
        $feed = new Feed(
            config('app.name'),
            config('app.url'),
            config('app.name')
        );

        $products = Product::active()->limit(1)->get();

        // Put products to the feed ($products - some data from database for example)
        foreach ($products as $product) {
            $item = new FeedProduct();

            $item->setId($product->id);
            $item->setTitle($product->fullname());

            if ($product->intro) {
                $item->setDescription(strip_tags($product->intro));
            } else {
                $item->setDescription(strip_tags($product->description));
            }

            $item->setLink($product->route());

            if ($product->hasImage()) {
                $item->setImage($product->firstImagePath());
            }

            $item->setAvailability($product);

            if ($product->hasPrice()) {
                $item->setTax($product->price());

                if ($product->isDiscounted()) {
                    $item->setPrice("{$product->getHighestPrice()->priceAppendingCurrencyString()}");
                    $item->setSalePrice("{$product->price()->priceAppendingCurrencyString()}");
                } else {
                    $item->setPrice("{$product->price()->priceAppendingCurrencyString()}");
                }
            }


            if ($product->category) {
                $item->setProductType($product->category->name);
                if ($google_category = $product->category->google) {
                    $item->setGoogleCategory($google_category);
                }
            }


            if ($product->brand) {
                $item->setBrand($product->brand->name);
            }
            if ($product->mpn) {
                $item->setMpn($product->mpn);
            }
            if ($product->gtin) {
                $item->setGtin($product->gtin);
            }


            $item->setCondition($product->getCondition());

            // Some additional properties
            // $item->setColor($product->color);
            // $item->setSize($product->size);

            // Shipping info
            $shipping = new Shipping;
            $shipping->setCountry('NL');
            // $shipping->setRegion('CA, NSW, 03');
            // $shipping->setPostalCode('94043');
            // $shipping->setLocationId('21137');
            $shipping->setService('Standard');
            $shipping->setPrice('6.95 EUR');
            $item->setShipping($shipping);

            // Add this product to the feed
            $feed->addProduct($item);
        }

        // Here we get complete XML of the feed, that we could write to file or send directly
        header("Content-Type:text/xml");
        die($feed->build());
    }
}
