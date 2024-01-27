<div style="height: 100vh;display: flex;flex-direction: row;justify-content: center;align-content: center;align-items: center;">
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    @if($registerForm)
        <form>
            <h2 style="padding:40px;" class="mb-5">Register</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name :</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="text" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Password :</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn text-white btn-success" wire:click.prevent="registerStore">Register</button>
                </div>
                <div class="col-md-12">
                    <div style="margin: 10px;">
                        <a class="text-primary" wire:click.prevent="register"><strong>Login</strong></a>
                    </div>
                </div>
            </div>
        </form>
    @else
        <form>
            <h2 style="padding:40px;" class="mb-5">Login</h2>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="text" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Password :</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn text-white btn-success" wire:click.prevent="login">Login</button>
                </div>
                <div class="col-md-12">
                    <div style="margin: 10px;">
                        Don't have account? <a class="btn btn-primary text-white" wire:click.prevent="register"><strong>Register Here</strong></a>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>
