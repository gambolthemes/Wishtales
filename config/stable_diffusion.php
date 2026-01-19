<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stable Diffusion / SDXL Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the AI image generation service.
    | Supports local (Automatic1111 WebUI) or cloud-hosted endpoints.
    |
    */

    'stable_diffusion' => [
        
        /*
        |--------------------------------------------------------------------------
        | API Endpoint
        |--------------------------------------------------------------------------
        |
        | The base URL for the Stable Diffusion API.
        | 
        | For local Automatic1111: http://localhost:7860
        | For RunPod: https://api.runpod.ai/v2/{pod_id}
        | For Replicate: https://api.replicate.com/v1
        |
        */
        'endpoint' => env('SD_API_ENDPOINT', 'http://localhost:7860'),

        /*
        |--------------------------------------------------------------------------
        | API Key
        |--------------------------------------------------------------------------
        |
        | Authentication key for cloud-hosted services.
        | Not required for local Automatic1111 (unless you've set one).
        |
        */
        'api_key' => env('SD_API_KEY'),

        /*
        |--------------------------------------------------------------------------
        | Model Checkpoint
        |--------------------------------------------------------------------------
        |
        | The model to use for image generation.
        | SDXL recommended for best quality.
        |
        */
        'model' => env('SD_MODEL', 'sdxl_base_1.0'),

        /*
        |--------------------------------------------------------------------------
        | Generation Steps
        |--------------------------------------------------------------------------
        |
        | Number of denoising steps. Higher = better quality but slower.
        | Recommended: 20-30 for balanced speed/quality.
        |
        */
        'steps' => env('SD_STEPS', 30),

        /*
        |--------------------------------------------------------------------------
        | CFG Scale
        |--------------------------------------------------------------------------
        |
        | How closely to follow the prompt. 
        | 7-10 recommended for good balance.
        |
        */
        'cfg_scale' => env('SD_CFG_SCALE', 7.5),

        /*
        |--------------------------------------------------------------------------
        | Sampler
        |--------------------------------------------------------------------------
        |
        | The sampling method to use.
        | DPM++ 2M Karras is fast and high quality.
        |
        */
        'sampler' => env('SD_SAMPLER', 'DPM++ 2M Karras'),

        /*
        |--------------------------------------------------------------------------
        | Request Timeout
        |--------------------------------------------------------------------------
        |
        | Maximum time (seconds) to wait for image generation.
        | Increase for higher resolution or more steps.
        |
        */
        'timeout' => env('SD_TIMEOUT', 120),

        /*
        |--------------------------------------------------------------------------
        | Max Retries
        |--------------------------------------------------------------------------
        |
        | Number of retry attempts on failure.
        |
        */
        'max_retries' => env('SD_MAX_RETRIES', 3),

        /*
        |--------------------------------------------------------------------------
        | Storage Configuration
        |--------------------------------------------------------------------------
        |
        | Where to store generated images.
        |
        */
        'storage_disk' => env('SD_STORAGE_DISK', 'public'),
        'storage_path' => env('SD_STORAGE_PATH', 'ai-cards'),

    ],

];
