const fs = require('fs');
const path = require('path');

const loginPath = 'd:/laragon/www/amerygo/resources/views/console/login.blade.php';
let html = fs.readFileSync(loginPath, 'utf8');

// Replace form opening tag
html = html.replace(/<form[^>]*id="kt_sign_in_form"[^>]*>/, `<form class="form w-100" method="POST" action="{{ route('console.login.post') }}" id="kt_sign_in_form">
                                @csrf`);

// Add error display for email
html = html.replace(/<!--begin::Email-->[\s\S]*?<input type="text" placeholder="Email" name="email"[^>]*>[\s\S]*?<!--end::Email-->/, `<!--begin::Email-->
                                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="form-control bg-transparent @error('email') is-invalid @enderror" />
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <!--end::Email-->`);

// Add error display for password
html = html.replace(/<!--begin::Password-->[\s\S]*?<input type="password" placeholder="Password" name="password"[^>]*>[\s\S]*?<!--end::Password-->/, `<!--begin::Password-->
                                    <input type="password" placeholder="Password" name="password" required autocomplete="current-password" class="form-control bg-transparent @error('password') is-invalid @enderror" />
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <!--end::Password-->`);

fs.writeFileSync(loginPath, html);
console.log('Login blade updated.');
