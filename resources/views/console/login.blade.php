<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Sign In - Console</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{ asset('metronic/assets/media/logos/favicon.ico') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('metronic/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<script>if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<body id="kt_body" class="app-blank">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<div class="w-lg-500px p-10">
							<form class="form w-100" method="POST" action="{{ route('console.login.post') }}" id="kt_sign_in_form">
                                @csrf
								<div class="text-center mb-11">
                                    <!-- Mobile Logo -->
                                    <img alt="Logo" src="{{ asset('assets/logos/logo_1.png') }}" class="h-60px h-lg-75px mb-5 d-lg-none" />
									<h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
								</div>
								<div class="fv-row mb-8">
                                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="form-control bg-transparent @error('email') is-invalid @enderror" />
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
								</div>
								<div class="fv-row mb-3">
                                    <input type="password" placeholder="Password" name="password" required autocomplete="current-password" class="form-control bg-transparent @error('password') is-invalid @enderror" />
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
								</div>
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<span class="indicator-label">Sign In</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--end::Body-->
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ asset('metronic/assets/media/misc/auth-bg.png') }})">
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                        <!-- Desktop Logo -->
						<a href="/" class="mb-0 mb-lg-12">
							<img alt="Logo" src="{{ asset('assets/logos/logo_2.png') }}" class="h-60px h-lg-75px" />
						</a>
					</div>
				</div>
				<!--end::Aside-->
			</div>
		</div>
		<script>var hostUrl = "assets/";</script>
		<script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
	</body>
</html>