<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait GeneratesApiResponses
{
    protected int $statusCode = 200;

    /**
     * @var array<string, string>
     */
    protected array $headers = [];

    protected function setStatusCode(int $code): self
    {
        $this->statusCode = $code;

        return $this;
    }

    protected function json(mixed $data = []): JsonResponse
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        if (is_array($data) && ! array_key_exists('data', $data)) {
            $data = ['data' => $data];
        }

        return response()->json(
            $data ?? [],
            $this->statusCode,
            $this->headers
        );
    }

    protected function jsonPlain(mixed $data): JsonResponse
    {
        return response()->json(
            $data,
            $this->statusCode,
            $this->headers
        );
    }

    protected function ok(mixed $data = []): JsonResponse
    {
        return $this
            ->setStatusCode(200)
            ->json($data);
    }

    protected function created(mixed $data = []): JsonResponse
    {
        return $this
            ->setStatusCode(201)
            ->json($data);
    }

    protected function noContent(mixed $data = []): JsonResponse
    {
        return $this
            ->setStatusCode(204)
            ->json($data);
    }

    protected function badRequest(mixed $data = []): JsonResponse
    {
        return $this
            ->setStatusCode(400)
            ->json($data);
    }

    protected function unauthorized(): JsonResponse
    {
        return $this
            ->setStatusCode(401)
            ->json();
    }

    protected function forbidden(): JsonResponse
    {
        return $this
            ->setStatusCode(403)
            ->json();
    }

    protected function notFound(): JsonResponse
    {
        return $this
            ->setStatusCode(404)
            ->json();
    }

    protected function invalidInput(mixed $data = []): JsonResponse
    {
        return $this
            ->setStatusCode(422)
            ->jsonPlain($data);
    }

    protected function internalError(): JsonResponse
    {
        return $this
            ->setStatusCode(500)
            ->json();
    }

    protected function notImplemented(): JsonResponse
    {
        return $this
            ->setStatusCode(501)
            ->json();
    }

    //    protected function pdf($view, $data, $filename): JsonResponse
    //    {
    //        $pdf = Pdf::loadView($view, $data)->stream($filename);
    //
    //        return $this->ok()->setData(
    //            base64_encode($pdf->content())
    //        );
    //    }
    //
    //    protected function pdfRaw($data): JsonResponse
    //    {
    //        return $this->ok()->setData(
    //            base64_encode($data)
    //        );
    //    }
}
