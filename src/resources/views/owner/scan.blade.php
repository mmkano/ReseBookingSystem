@extends('layouts.owner')

@section('title', 'QRコードスキャン')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/scan.css') }}">
@endsection

@section('content')
<h1>QRコードスキャン</h1>
<div id="video-container">
    <video id="preview"></video>
</div>
<form id="scan-form" action="{{ route('owner.scan.post') }}" method="POST">
    @csrf
    <input type="hidden" id="qr_code" name="qr_code">
    <button type="submit" style="display: none;">スキャン</button>
</form>
@endsection

@section('scripts')
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
    window.addEventListener('load', function() {
        let selectedDeviceId;
        const codeReader = new ZXing.BrowserMultiFormatReader();
        codeReader.listVideoInputDevices()
            .then(videoInputDevices => {
                selectedDeviceId = videoInputDevices[0].deviceId;
                codeReader.decodeFromVideoDevice(selectedDeviceId, 'preview', (result, err) => {
                    if (result) {
                        document.getElementById('qr_code').value = result.text;
                        document.getElementById('scan-form').submit();
                    }
                    if (err && !(err instanceof ZXing.NotFoundException)) {
                        console.error(err);
                    }
                });
            })
            .catch(err => console.error(err));
    });
</script>
@endsection
