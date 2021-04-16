<?php

namespace Drupal\webspark_isearch\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * An example controller.
 */
class iSearchController extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function content() {
    $config = \Drupal::config('isearch.settings');
    $solr = $config->get('solr');
    $client = \Drupal::httpClient();
    $query= \Drupal::request()->getQueryString();

    $url = $solr . '?' . urldecode($query);

    $request = $client->get($url);
    $status = $request->getStatusCode();
    $content = $request->getBody()->getContents();
    $file_contents = json_decode($content);

    return new JsonResponse($file_contents);
  }

}
