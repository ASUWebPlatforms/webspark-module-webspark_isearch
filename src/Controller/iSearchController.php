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
    $result = '';
    $client = \Drupal::httpClient();
    try {
      $config = \Drupal::config('webspark_isearch.settings');
      $solr = $config->get('solr');
      $query= \Drupal::request()->getQueryString();
      $url = $solr . '?' . urldecode($query);
      $request = $client->get($url);
      $code = $request->getStatusCode();
      if ($code == 200) {
        $content = $request->getBody()->getContents();
        $file_contents = json_decode($content);
        $result = new JsonResponse($file_contents);
      }
    }
    catch (RequestException $e) {
      \Drupal::logger('webspark_isearch')->error($e->getMessage());
    }
    return $result;
  }
}
