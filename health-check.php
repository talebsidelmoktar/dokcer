<?php
/**
 * Simple health check endpoint for Render
 */

// Check if WordPress is properly loaded
if (function_exists('wp_get_environment_type')) {
    http_response_code(200);
    echo json_encode([
        'status' => 'healthy',
        'timestamp' => date('Y-m-d H:i:s'),
        'wordpress' => 'loaded'
    ]);
} else {
    http_response_code(503);
    echo json_encode([
        'status' => 'unhealthy',
        'timestamp' => date('Y-m-d H:i:s'),
        'error' => 'WordPress not loaded'
    ]);
}
?>
