<?php
	namespace core;

	abstract class Middleware {
		/**
		 * @desc handle middleware logic
		 * @param Request $request
		 * @return mixed
		 */
		abstract public function handle($request);
	}