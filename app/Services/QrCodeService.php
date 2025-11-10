<?php
namespace App\Services;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class QrCodeService
{
    public function generateQrCode(string $data, string $path, int $size = 300)
    {
        try {
            $renderer = new ImageRenderer(new RendererStyle($size), new ImagickImageBackEnd());
            $writer = new Writer($renderer);
            $qrCodeImage = $writer->writeString($data);
            Storage::disk('public')->put($path, $qrCodeImage);
        } catch (\Exception $e) {
            Log::error('Erreur génération QR code: ' . $e->getMessage());
            return null;
        }

        return $path;
    }
}
