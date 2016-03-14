<?php namespace HubIT\Controllers\Api;

use HubIT\Requests\PostCoordinatesRequest;
use HubIT\Services\CoordinatesService;
use HubIT\Transformers\ApiCoordinatesTransformer;

/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  10/03/16
 */
class ApiCoordinatesController extends ApiController
{
	/**
	 * @var PostCoordinatesRequest
	 */
	private $postCoordinatesRequest;
	/**
	 * @var CoordinatesService
	 */
	private $coordinatesService;
	/**
	 * @var ApiCoordinatesTransformer
	 */
	private $apiCoordinatesTransformer;

	/**
	 * CoordinatesController constructor.
	 */
	public function __construct()
	{
		$this->coordinatesService = new CoordinatesService();
		$this->postCoordinatesRequest = new PostCoordinatesRequest();
		$this->apiCoordinatesTransformer = new ApiCoordinatesTransformer();
	}

	/**
	 * Async return coordinate resulsts.
	 *
	 * @return string
	 */
	public function getCoordinates()
	{
		$this->postCoordinatesRequest->validate();

		$location = $this->postCoordinatesRequest->getLocation();

		$coordinates = $this->coordinatesService->getCoordinates($location);

		if ( ! $coordinates ) return $this->respondInternalServerError();

		return $this->respondWithSuccess(
			$this->apiCoordinatesTransformer->transform($coordinates)
		);
	}
}