<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">{{ setting('footer_text') ?? config('admin.footer_text')}}</div>
    <strong>
        Copyright &copy; 2014-2023
        <a href="{{ url('/') }}">{{ config('admin.appName', 'app.name') }}</a>.
    </strong>
    All rights reserved.
</footer>