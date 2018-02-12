<?php
interface APIHandlerInterface
{
	public function getRequestMethod();
	public function getUrlPath();
	public function getRequestBody();
	public function getRequestHeaders();
	public function getRequestParams();
	public function getRequestHeadersAsMap();
	public function getRequestParamsAsMap();
}
?>