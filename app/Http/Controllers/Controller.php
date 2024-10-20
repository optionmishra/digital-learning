<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

abstract class Controller
{
    public function restrictedAction()
    {
        $data = [
            'error' => true,
            'message' => 'Restricted',
        ];
        return response()->json(compact('data'), 403);
    }

    /**
     * Generate data for a DataTable based on the provided repository.
     *
     * @param mixed $repository The repository used to retrieve the data.
     * @return array The generated data for the DataTable.
     */
    public function generateDataTableData($repository)
    {
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['name'] ?? 'id';
        $sortDirection = request()->get('order')[0]['dir'] ?? 'asc';
        $searchValue = request()->get('search')['value'];
        $columns = array_map(fn($column) => $column['data'], request()->get('columns'));

        $count = $repository->paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $data = $repository->paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue);

        return $data = array(
            "draw"            => intval(request()->input('draw')),
            "recordsTotal"    => intval($count),
            "recordsFiltered" => intval($count),
            "data"            => $data
        );
    }

    /**
     * Generates a JSON response with a boolean error flag and a message.
     *
     * @param bool $action The action status.
     * @param string $message The response message.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function jsonResponse($action, $message)
    {
        return response()->json([
            'error' => !$action,
            'message' => !$action ? 'Error processing request' : $message,
        ], $action ? 200 : 500);
    }

    /**
     * Uploads a file to the specified directory and returns the generated filename and file type.
     *
     * @param \Illuminate\Http\UploadedFile $file The file to be uploaded.
     * @param string $directory The directory where the file will be stored.
     * @return array The generated filename and file type.
     */
    protected function uploadFile($file, $directory)
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $filetype = $this->getFiletype($file);
        $file->storeAs($directory, $filename, 'public');
        return ['name' => $filename, 'type' => $filetype];
    }

    /**
     * Returns the file type based on the file extension.
     *
     * @param \Illuminate\Http\UploadedFile $file The file to determine the file type for.
     * @return string The file type (img or vid).
     */
    protected function getFiletype($file)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file->getRealPath());
        finfo_close($finfo);

        $imgTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp'];
        $vidTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime'];

        if (in_array($mimeType, $imgTypes)) {
            return 'img';
        }

        if (in_array($mimeType, $vidTypes)) {
            return 'vid';
        }

        return 'other';
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendAPIResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendAPIError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
