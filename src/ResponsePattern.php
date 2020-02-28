<?php

namespace Oportunista;


class ResponsePattern
{
    private $data;
    private $error = array();
    private $response = array();

    public function __construct($data = null, $error = null)
    {
        $this->data = "";
        $this->error = [
            'status' => false,
            'message' => ""
        ];

        if ($data) {
            $this->data = $data;
        }

        if ($error) {
            $this->error = [
                'status' => true,
                'error' => "$error"
            ];
        }

    }

    public function getResponse()
    {
        $this->response['data'] = $this->data;
        $this->response['error'] = $this->error;

        return $this->response;
    }


}