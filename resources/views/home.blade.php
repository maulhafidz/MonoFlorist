@php
    $byName = collect($flowers)->keyBy('name');
    $minWrap = collect($wrappings)->min('price');
    $starters = collect(config('shop.starters'))->map(function ($s) use ($byName, $minWrap) {
        $sum = 0;
        foreach ($s['mix'] as $name => $q) { $sum += $q * ($byName[$name]['price'] ?? 0); }
        return $s + ['price' => $sum + $minWrap];
    })->values()->all();
    $photoBouquets = collect(config('shop.bouquets'))->map(fn ($b) => [
        'name' => $b['name'], 'desc' => $b['desc'], 'price' => $b['price'], 'mix' => null,
        'image' => asset('images/bouquets/' . $b['image']),
    ])->all();
    $carousel = $photoBouquets;
    $occasions = config('shop.occasions');
    $builder = config('shop.builder_enabled');
    $tagline = $builder ? config('shop.tagline_builder') : config('shop.tagline');
    $waUrl = $preorderUrl . (str_contains($preorderUrl, '?') ? '&' : '?') . 'text=' . rawurlencode(config('shop.whatsapp_greeting'));
    $orderHref = $builder ? '#build' : $waUrl;
    $orderAttrs = $builder ? '' : 'target=_blank rel=noopener';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $shop }} — {{ $builder ? 'Build Your Own Bouquet' : 'Artificial Flower Bouquets' }}</title>
    <meta name="description" content="{{ $tagline }}">
    <meta name="theme-color" content="#3F5C50">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $shop }} — {{ $builder ? 'Build Your Own Bouquet' : 'Artificial Flower Bouquets' }}">
    <meta property="og:description" content="{{ $tagline }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset(config('shop.logo')) }}">
    <link rel="icon" type="image/jpeg" href="{{ asset(config('shop.logo')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Jost:wght@300;400;500&family=Marcellus&display=swap" rel="stylesheet">
    <script>document.documentElement.classList.add('js')</script>
    <style>
        :root { --sage:#4F6E62; --forest:#123F31; --green:#1F4D3F; --cream:#FBF7F1; --sand:#F1ECE3; --line:#E3DCCF; --gold:#8A6A3C; --ink:#1F2B26; --muted:#5C6B64; --soft:#4A5852; }
        * { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; scroll-padding-top:90px; overflow-x:clip; }
        body { font-family:'Jost',system-ui,sans-serif; font-weight:400; color:var(--ink); background:var(--cream); line-height:1.6; overflow-x:clip; }
        a { color:inherit; text-decoration:none; }
        button { font:inherit; cursor:pointer; color:inherit; }
        h1,h2,h3 { font-family:'Cormorant Garamond',Georgia,serif; font-weight:500; line-height:1.1; }
        .wrap { max-width:1360px; margin:0 auto; padding:0 40px; }
        .eyebrow { text-transform:uppercase; letter-spacing:.24em; font-size:.8rem; color:var(--muted); display:block; margin-bottom:8px; }
        .vh { position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0); }

        /* buttons */
        .btn { display:inline-flex; align-items:center; justify-content:center; min-height:48px; padding:0 32px; border:1px solid var(--green); border-radius:999px;
               text-transform:uppercase; letter-spacing:.14em; font-size:.85rem; background:transparent; color:var(--green); transition:background .25s, color .25s, border-color .25s; }
        .btn:hover { background:var(--green); color:#fff; }
        .btn-solid { background:var(--green); color:#fff; }
        .btn-solid:hover { background:var(--forest); }
        .btn-gold { background:var(--gold); border-color:var(--gold); color:#fff; }
        .btn-gold:hover { background:#6f532d; border-color:#6f532d; }
        .btn[aria-disabled="true"] { opacity:.4; pointer-events:none; }

        /* header */
        header { background:rgba(63,92,80,.86); -webkit-backdrop-filter:blur(16px) saturate(1.3); backdrop-filter:blur(16px) saturate(1.3);
                 border-bottom:1px solid rgba(255,255,255,.14); color:#fff; position:sticky; top:0; z-index:20; }
        @supports not ((backdrop-filter:blur(1px)) or (-webkit-backdrop-filter:blur(1px))) { header { background:#3F5C50; } }
        header nav { max-width:1440px; margin:0 auto; padding:16px 40px; display:flex; align-items:center; justify-content:space-between; gap:24px; }
        .nav-side { display:flex; gap:44px; align-items:center; flex:1 1 0; }
        .nav-right { display:flex; gap:28px; align-items:center; justify-content:flex-end; flex:1 1 0; }
        .navlink { position:relative; font-size:.9rem; letter-spacing:.16em; text-transform:uppercase; min-height:44px; display:inline-flex; align-items:center; transition:transform .3s ease, color .3s ease; }
        .navlink::after { content:''; position:absolute; left:0; right:0; bottom:8px; height:1px; background:currentColor; transform:scaleX(0); transform-origin:center; transition:transform .35s cubic-bezier(.4,0,.2,1); }
        .navlink:hover, .navlink:focus-visible { transform:translateY(-2px); }
        .navlink:hover::after, .navlink:focus-visible::after { transform:scaleX(1); }
        .logo { display:flex; align-items:center; gap:14px; flex:0 0 auto; }
        .badge { width:68px; height:68px; border-radius:50%; overflow:hidden; background:#FBFAF5; flex:0 0 auto; box-shadow:0 2px 10px rgba(18,63,49,.25); }
        .badge img { width:100%; height:100%; display:block; object-fit:cover; transform:scale(1.38); }
        .logo .txt { display:flex; flex-direction:column; gap:4px; }
        .logo .name { font-family:'Marcellus',serif; font-size:clamp(1.3rem,2.6vw,2rem); line-height:1; letter-spacing:.12em; text-transform:uppercase; }
        .logo .sub { font-weight:500; font-size:.7rem; letter-spacing:.38em; }
        footer .badge { width:56px; height:56px; box-shadow:none; border:1px solid var(--line); }
        .pill { white-space:nowrap; display:inline-flex; align-items:center; min-height:40px; padding:0 22px; border-radius:999px; background:var(--cream); color:var(--green); font-size:.8rem; letter-spacing:.14em; text-transform:uppercase; transition:background .3s ease, transform .3s ease, box-shadow .3s ease; }
        .pill:hover { background:#fff; transform:translateY(-2px); box-shadow:0 6px 16px rgba(18,63,49,.25); }
        .bag { position:relative; width:44px; height:44px; display:inline-flex; align-items:center; justify-content:center; transition:transform .3s ease; }
        .bag:hover { transform:translateY(-2px) scale(1.1); }
        .bag span { position:absolute; top:3px; right:0; font-size:.7rem; font-weight:500; }

        /* featured carousel */
        .featured { position:relative; padding:72px 0 64px; overflow-x:clip; }
        .watermark { position:absolute; top:8px; left:0; right:0; text-align:center; font-family:'Cormorant Garamond',serif; font-weight:600; font-size:clamp(5rem,12vw,10.5rem); line-height:1; letter-spacing:.04em; color:var(--green); opacity:.06; white-space:nowrap; pointer-events:none; user-select:none; }
        .f-head { position:relative; display:flex; justify-content:space-between; align-items:flex-end; gap:24px; flex-wrap:wrap; margin-bottom:40px; }
        .f-head h1 { font-size:clamp(2.2rem,4.4vw,3.3rem); color:var(--green); max-width:760px; }
        .f-sub { margin-top:14px; max-width:560px; color:var(--soft); font-size:1.05rem; }
        .f-head a { font-size:.9rem; letter-spacing:.14em; text-underline-offset:6px; text-decoration:underline; min-height:44px; display:inline-flex; align-items:center; text-transform:uppercase; }
        .slider { position:relative; }
        .track { display:flex; overflow-x:auto; scroll-snap-type:x mandatory; scroll-behavior:smooth; overscroll-behavior-x:contain; scrollbar-width:none; -webkit-overflow-scrolling:touch; outline-offset:6px; }
        .track::-webkit-scrollbar { display:none; }
        .slide { flex:0 0 100%; min-width:0; scroll-snap-align:center; scroll-snap-stop:always; display:grid; grid-template-columns:minmax(0,520px) minmax(0,420px); justify-content:center; align-items:center; gap:72px; padding:8px 0 28px; }
        .photo { aspect-ratio:1; border-radius:6px; overflow:hidden; background:#E9E1D3; box-shadow:0 18px 40px rgba(18,63,49,.22); }
        .photo img { width:100%; height:100%; object-fit:cover; display:block; transform:scale(1.22); }
        .detail { display:flex; flex-direction:column; align-items:flex-start; gap:10px; }
        .detail .eyebrow { margin-bottom:0; }
        .detail h2 { font-size:clamp(2.1rem,3.8vw,3.1rem); color:var(--green); }
        .detail p { color:var(--soft); font-size:1.05rem; max-width:420px; }
        .price-tag { font-size:.9rem; letter-spacing:.12em; color:var(--gold); }
        .detail .btn { margin-top:12px; }
        .controls { position:relative; display:flex; align-items:center; justify-content:space-between; gap:24px; margin-top:40px; flex-wrap:wrap; }
        .dots { display:flex; align-items:center; gap:4px; }
        .dots button { width:32px; height:44px; border:0; background:transparent; display:inline-flex; align-items:center; justify-content:center; padding:0; }
        .dots i { width:14px; height:14px; border-radius:50%; background:#A9C4B8; display:block; transition:background .3s, transform .3s; }
        .dots button.on i { background:var(--green); transform:scale(1.1); }
        .prog { display:flex; align-items:center; gap:20px; flex:0 1 520px; min-width:260px; }
        .prog .count { font-size:.85rem; letter-spacing:.12em; color:var(--muted); white-space:nowrap; }
        .bar-track { flex:1 1 auto; height:8px; border-radius:8px; border:1px solid #A9BDB4; background:#fff; overflow:hidden; }
        .bar-fill { height:100%; background:var(--green); border-radius:8px; transition:width .5s ease; }
        .arrows { display:flex; gap:8px; }
        .arrow { width:44px; height:44px; border-radius:50%; border:1px solid var(--green); background:transparent; color:var(--green); display:inline-flex; align-items:center; justify-content:center; transition:background .2s, color .2s; }
        .arrow:hover, .arrow.fill { background:var(--green); color:#fff; }

        /* sections */
        section { padding:88px 0; }
        .head { text-align:center; margin-bottom:48px; }
        .head h2 { font-size:clamp(2rem,3.8vw,2.9rem); color:var(--green); }
        .head p { color:var(--muted); max-width:480px; margin:12px auto 0; }

        /* occasions */
        .occ-bg { background:var(--sand); }
        .occ-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:24px; }
        .occ { text-align:left; background:var(--cream); border:1px solid transparent; border-radius:6px; padding:32px 28px; display:flex; flex-direction:column; gap:14px; min-height:200px; transition:border-color .25s, transform .25s; }
        .occ:hover { border-color:var(--green); transform:translateY(-3px); }
        .occ h3 { font-weight:600; font-size:1.75rem; color:var(--green); }
        .occ p { font-size:.95rem; line-height:1.5; color:var(--soft); }

        /* builder */
        .builder { display:grid; grid-template-columns:1fr 380px; gap:40px; align-items:start; }
        .flowers { display:grid; grid-template-columns:repeat(auto-fill,minmax(190px,1fr)); gap:22px; }
        .flower { background:var(--sand); border-radius:8px; overflow:hidden; transition:box-shadow .3s; }
        .flower.picked { box-shadow:0 0 0 1.5px var(--green); }
        .flower.sold { opacity:.55; }
        .flower .img { aspect-ratio:1; background-size:cover; background-position:center 42%; display:flex; align-items:center; justify-content:center; font-size:3rem; }
        .flower .info { padding:14px 16px 16px; }
        .flower h3 { font-size:1.4rem; font-weight:600; color:var(--green); }
        .flower .price { font-size:.82rem; color:var(--muted); letter-spacing:.05em; }
        .flower .note { display:block; font-size:.8rem; color:var(--muted); margin-top:4px; line-height:1.45; }
        .flower .sold-tag { display:block; text-align:center; margin-top:12px; font-size:.72rem; text-transform:uppercase; letter-spacing:.15em; color:var(--muted); padding:9px 0; }
        .stepper { display:flex; align-items:center; justify-content:space-between; margin-top:12px; border:1px solid var(--line); background:var(--cream); border-radius:999px; padding:3px; }
        .stepper button { width:36px; height:36px; border-radius:50%; border:0; background:var(--sand); color:var(--green); font-size:1.1rem; transition:background .2s, color .2s; }
        .stepper button:hover { background:var(--green); color:#fff; }
        .stepper output { font-size:.95rem; min-width:24px; text-align:center; }

        .summary { position:sticky; top:110px; background:#fff; border:1px solid var(--line); border-radius:8px; padding:28px; box-shadow:0 10px 40px rgba(18,63,49,.08); }
        .summary h3 { font-size:2rem; font-weight:600; color:var(--green); margin-bottom:6px; }
        .size { display:inline-block; font-family:'Jost',sans-serif; font-size:.7rem; text-transform:uppercase; letter-spacing:.15em; background:var(--green); color:#fff; border-radius:999px; padding:2px 12px; margin-left:8px; vertical-align:middle; font-weight:400; }
        .size[hidden], .occasion[hidden] { display:none; }
        .occasion { font-size:.82rem; color:var(--gold); letter-spacing:.08em; margin-bottom:6px; }
        .summary .empty { color:var(--muted); font-size:.92rem; padding:10px 0 18px; }
        .lines { list-style:none; margin-bottom:14px; }
        .lines li { display:flex; justify-content:space-between; gap:12px; font-size:.92rem; padding:5px 0; border-bottom:1px dashed var(--line); }
        .summary label, .summary legend { display:block; text-transform:uppercase; letter-spacing:.15em; font-size:.68rem; color:var(--muted); margin:16px 0 6px; padding:0; }
        .summary fieldset { border:0; }
        .opt { display:flex; justify-content:space-between; align-items:center; font-size:.92rem; padding:4px 0; cursor:pointer; text-transform:none; letter-spacing:0; color:var(--ink); margin:0 !important; font-size:.92rem !important; }
        .opt input { accent-color:var(--green); margin-right:8px; }
        .summary input[type=date], .summary textarea { width:100%; border:1px solid var(--line); background:var(--cream); border-radius:8px; padding:9px 12px; font:inherit; font-size:.92rem; color:var(--ink); }
        .summary textarea { resize:vertical; min-height:64px; }
        .total { display:flex; justify-content:space-between; align-items:baseline; margin:20px 0 10px; padding-top:14px; border-top:1px solid var(--green); }
        .total span:first-child { text-transform:uppercase; letter-spacing:.15em; font-size:.75rem; }
        .total strong { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:600; color:var(--green); }
        .hint { font-size:.84rem; color:#9a4a35; margin:0 0 12px; min-height:1.2em; }
        .summary .btn { width:100%; }
        .summary .clear { display:block; width:100%; text-align:center; margin-top:10px; background:none; border:0; color:var(--muted); font-size:.82rem; text-decoration:underline; min-height:36px; }

        /* how */
        .how { background:var(--sand); padding:70px 0; }
        .steps { display:grid; grid-template-columns:repeat(3,1fr); gap:30px; text-align:center; }
        .step b { font-family:'Cormorant Garamond',serif; font-size:2.8rem; font-weight:500; color:#B9C9C0; display:block; line-height:1.1; }
        .step h3 { font-size:1.65rem; font-weight:600; color:var(--green); margin-bottom:6px; }
        .step p { color:var(--soft); max-width:300px; margin:0 auto; }

        /* testimonials */
        .quotes { display:grid; grid-template-columns:repeat(3,1fr); gap:48px; text-align:center; }
        .quote q { display:block; font-family:'Cormorant Garamond',serif; font-size:1.55rem; font-weight:500; font-style:italic; line-height:1.4; quotes:none; color:var(--green); }
        .quote cite { display:block; margin-top:16px; text-transform:uppercase; letter-spacing:.2em; font-size:.74rem; font-style:normal; color:var(--muted); }

        /* story */
        .story { background:var(--forest); color:var(--cream); padding:96px 0; }
        .story .in { max-width:880px; margin:0 auto; padding:0 40px; display:flex; flex-direction:column; gap:24px; align-items:center; text-align:center; }
        .story .eyebrow { color:#C9DAD2; margin:0; }
        .story h2 { font-size:clamp(2.1rem,4.2vw,3rem); line-height:1.15; }
        .story p { font-size:1.08rem; line-height:1.7; color:#DCE7E1; max-width:640px; }

        /* info + faq */
        .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:32px; text-align:center; }
        .info-item h3 { font-size:1.55rem; font-weight:600; color:var(--green); margin-bottom:6px; }
        .info-item p { color:var(--soft); font-size:.95rem; }
        .faq { max-width:760px; margin:0 auto; }
        .faq details { border-bottom:1px solid var(--line); padding:20px 0; }
        .faq summary { cursor:pointer; list-style:none; display:flex; justify-content:space-between; gap:20px; font-family:'Cormorant Garamond',serif; font-weight:600; font-size:1.5rem; color:var(--green); }
        .faq summary::-webkit-details-marker { display:none; }
        .faq summary::after { content:'+'; font-family:'Jost',sans-serif; font-weight:300; transition:transform .3s; }
        .faq details[open] summary::after { transform:rotate(45deg); }
        .faq details p { color:var(--soft); margin-top:10px; }

        /* footer */
        footer { background:var(--cream); border-top:1px solid var(--line); padding:48px 0; }
        footer .row { display:flex; justify-content:space-between; align-items:center; gap:24px; flex-wrap:wrap; }
        footer .brand { font-family:'Marcellus',serif; font-size:1.4rem; letter-spacing:.12em; color:var(--green); text-transform:uppercase; }
        footer .soc { display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
        footer .circle { width:52px; height:52px; border-radius:50%; background:var(--gold); color:#fff; display:inline-flex; align-items:center; justify-content:center; transition:background .2s; }
        footer .circle:hover, footer .tel:hover { background:#6f532d; }
        footer .tel { height:52px; padding:0 28px; border-radius:999px; background:var(--gold); color:#fff; display:inline-flex; align-items:center; gap:10px; font-size:1rem; letter-spacing:.06em; transition:background .2s; }
        footer .loc { display:flex; align-items:center; gap:8px; margin-top:12px; font-size:.92rem; color:var(--soft); }

        /* mobile order bar */
        .mbar { display:none; position:fixed; left:0; right:0; bottom:0; z-index:30; background:rgba(251,247,241,.96); backdrop-filter:blur(8px);
                border-top:1px solid var(--line); padding:12px 20px; align-items:center; justify-content:space-between; gap:14px;
                transform:translateY(110%); transition:transform .4s ease; }
        .mbar.show { transform:none; }
        .mbar div { display:flex; flex-direction:column; line-height:1.3; }
        .mbar strong { font-weight:500; color:var(--green); font-size:.95rem; }
        .mbar span { font-size:.8rem; color:var(--muted); }
        .mbar .btn { min-height:44px; padding:0 22px; white-space:nowrap; font-size:.78rem; }

        /* scroll fade: opacity + translate are driven by scroll position (see script) */
        .js .reveal { will-change:opacity, translate; }
        @media (prefers-reduced-motion:reduce) {
            .js .reveal { transition:none; }
            .bar-fill { transition:none; }
            .track { scroll-behavior:auto; }
            html { scroll-behavior:auto; }
        }

        @media (max-width:960px) {
            .builder { grid-template-columns:1fr; }
            .summary { position:static; }
            .mbar { display:flex; }
            body { padding-bottom:70px; }
            .info-grid { grid-template-columns:repeat(2,1fr); }
        }
        @media (max-width:860px) {
            .wrap { padding:0 24px; }
            header nav { padding:14px 20px; }
            .nav-side, .nav-right .navlink { display:none; }
            .occ-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
            .steps, .quotes { grid-template-columns:1fr; }
            section { padding:64px 0; }
            .featured { padding:48px 0 48px; }
            .badge { width:52px; height:52px; }
            .logo .sub { display:none; }
        }
        @media (max-width:520px) {
            .occ-grid { grid-template-columns:1fr; }
            .info-grid { grid-template-columns:1fr; }
            .prog { flex:1 1 100%; }
            .pill { padding:0 16px; }
        }
        /* ---------- mobile only (desktop look is unchanged) ---------- */
        .burger, .mmenu { display:none; }
        .burger .i-close { display:none; }
        .burger[aria-expanded="true"] .i-open { display:none; }
        .burger[aria-expanded="true"] .i-close { display:block; }
        .mbar { padding-bottom:calc(12px + env(safe-area-inset-bottom)); }

        @media (max-width:860px) {
            header { -webkit-backdrop-filter:blur(10px) saturate(1.2); backdrop-filter:blur(10px) saturate(1.2); }
            header nav { padding-left:max(20px, env(safe-area-inset-left)); padding-right:max(20px, env(safe-area-inset-right)); }
            .nav-right { gap:6px; }
            .pill { min-height:44px; }
            .watermark { font-size:15vw; }
            .slide { grid-template-columns:minmax(0,1fr); gap:22px; padding-bottom:16px; }
            .photo { width:100%; max-width:520px; margin:0 auto; }
            .detail { align-items:center; text-align:center; }
            .detail p { max-width:none; }
            .burger { display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; border:0; background:transparent; color:#fff; border-radius:50%; }
            .burger:active { background:rgba(255,255,255,.15); }
            .mmenu:not([hidden]) { display:flex; flex-direction:column; padding:8px 20px 16px; border-top:1px solid rgba(255,255,255,.14); }
            .mmenu a { display:flex; align-items:center; min-height:52px; font-size:1rem; letter-spacing:.16em; text-transform:uppercase; border-bottom:1px solid rgba(255,255,255,.1); }
            .mmenu a:last-child { border-bottom:0; }
            .stepper button { width:40px; height:40px; }
            .summary .clear { min-height:44px; }
        }
        @media (max-width:520px) {
            .flowers { grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
            .flower .info { padding:10px 12px 14px; }
            .flower h3 { font-size:1.2rem; }
            .flower .price { font-size:.76rem; }
            .flower .note { font-size:.74rem; line-height:1.4; }
            .logo .name { font-size:1.15rem; letter-spacing:.1em; }
            .badge { width:46px; height:46px; }
            .logo { gap:10px; }
        }
        @media (max-width:420px) {
            header nav { gap:8px; }
            .logo { gap:8px; min-width:0; }
            .logo .name { font-size:.95rem; letter-spacing:.06em; }
            .badge { width:42px; height:42px; }
            .nav-right { gap:2px; }
            .pill { padding:0 12px; font-size:.68rem; letter-spacing:.1em; }
            .burger { width:40px; }
        }
    </style>
</head>
<body>
    <header>
        <nav aria-label="Main">
            <div class="nav-side">
                <a class="navlink" href="#designs">Designs</a>
                <a class="navlink" href="{{ $builder ? '#build' : '#flowers' }}">{{ $builder ? 'Build' : 'Flowers' }}</a>
                <a class="navlink" href="#faq">FAQ</a>
            </div>

            <a href="{{ route('home') }}" class="logo" aria-label="{{ $shop }}, home">
                <span class="badge"><img src="{{ asset(config('shop.logo')) }}" alt="" width="72" height="72"></span>
                <span class="txt">
                    <span class="name">{{ $shop }}</span>
                    <span class="sub">FLOWER STUDIO</span>
                </span>
            </a>

            <div class="nav-right">
                <a class="navlink" href="#contact">Contact</a>
                <a href="{{ $orderHref }}" {!! $orderAttrs !!} class="pill">Pre-Order</a>
                @if ($builder)
                <a href="#build" class="bag" aria-label="Your bouquet">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 4h2l2.4 11h11L21 8H6.2"/><circle cx="9" cy="19.5" r="1.3"/><circle cx="17" cy="19.5" r="1.3"/></svg>
                    <span id="navCount">0</span>
                </a>
                @endif
                <button type="button" class="burger" id="burger" aria-label="Open menu" aria-expanded="false" aria-controls="mmenu">
                    <svg class="i-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    <svg class="i-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </nav>
        <div class="mmenu" id="mmenu" hidden>
            <a href="#designs">Designs</a>
            <a href="{{ $builder ? '#build' : '#flowers' }}">{{ $builder ? 'Build' : 'Flowers' }}</a>
            <a href="#how">How it works</a>
            <a href="#faq">FAQ</a>
            <a href="#contact">Contact</a>
        </div>
    </header>

    <!-- Featured designs carousel -->
    <section id="designs" class="featured" aria-labelledby="featured-title">
        <div class="watermark" aria-hidden="true">IN BLOOM</div>
        <div class="wrap">
            <div class="f-head head-r">
                <div>
                    <span class="eyebrow">Handmade pipe cleaner flowers</span>
                    <h1 id="featured-title">Flowers that never wilt, made by hand</h1>
                    <p class="f-sub">Soft, lifelike bouquets crafted stem by stem from pipe cleaners. Choose a bouquet below and pre-order on WhatsApp.</p>
                </div>
                @if ($builder)
                    <a href="#build">Build your own</a>
                @else
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener">Pre-order on WhatsApp</a>
                @endif
            </div>

            <div class="slider" aria-roledescription="carousel" aria-label="Featured bouquets">
                <div class="track" id="track" tabindex="0">
                    @foreach ($carousel as $b)
                        <article class="slide" aria-roledescription="slide" aria-label="{{ $loop->iteration }} of {{ $loop->count }}">
                            <div class="photo">
                                <img src="{{ $b['image'] }}" alt="{{ $b['name'] }}" draggable="false" @if (! $loop->first) loading="lazy" @endif>
                            </div>
                            <div class="detail">
                                <span class="eyebrow">Bouquet {{ $loop->iteration }} of {{ $loop->count }}</span>
                                <h2>{{ $b['name'] }}</h2>
                                <p>{{ $b['desc'] }}</p>
                                @if ($b['price'])
                                    <span class="price-tag">STARTING AT Rp {{ number_format($b['price'], 0, ',', '.') }}</span>
                                @endif
                                <button type="button" class="btn btn-solid ask" data-i="{{ $loop->index }}">Ask about this bouquet</button>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="controls">
                <div class="dots" id="dots"></div>
                <div class="prog">
                    <span class="count" id="count">01 / 01</span>
                    <div class="bar-track"><div class="bar-fill" id="fill"></div></div>
                    <div class="arrows">
                        <button type="button" class="arrow" id="prev" aria-label="Previous bouquet"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg></button>
                        <button type="button" class="arrow fill" id="next" aria-label="Next bouquet"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Occasions -->
    <section class="occ-bg" aria-labelledby="occ-title">
        <div class="wrap">
            <div class="head">
                <span class="eyebrow">Shop by occasion</span>
                <h2 id="occ-title">Something for every moment</h2>
            </div>
            <div class="occ-grid">
                @foreach ($occasions as $o => $occ)
                    <button type="button" class="occ" data-o="{{ $o }}">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#1F4D3F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $occ['icon'] !!}</svg>
                        <h3>{{ $occ['name'] }}</h3>
                        <p>{{ $occ['desc'] }}</p>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    @unless ($builder)
    <!-- Showcase: flowers (builder is off, see config/shop.php builder_enabled) -->
    <section id="flowers" aria-labelledby="flowers-title">
        <div class="wrap">
            <div class="head">
                <span class="eyebrow">Made by hand</span>
                <h2 id="flowers-title">Our Flowers</h2>
                <p>The stems we use in our bouquets. Tell us your favorites on WhatsApp and we will arrange them for you.</p>
            </div>
            <div class="flowers">
                @foreach ($flowers as $i => $f)
                    <article class="flower {{ $f['available'] ? '' : 'sold' }}">
                        <div class="img" style="background-color:{{ $f['color'] }}; @if ($f['image']) background-image:url('{{ asset('images/flowers/'.$f['image']) }}') @endif">
                            @unless ($f['image']) 🌸 @endunless
                        </div>
                        <div class="info">
                            <h3>{{ $f['name'] }}</h3>
                            <span class="price">Rp {{ number_format($f['price'], 0, ',', '.') }} / stem</span>
                            <span class="note">{{ $f['note'] }}</span>
                            @unless ($f['available']) <span class="sold-tag">Sold out</span> @endunless
                        </div>
                    </article>
                @endforeach
            </div>
            <div style="text-align:center; margin-top:48px">
                <a href="{{ $waUrl }}" class="btn btn-solid" target="_blank" rel="noopener">Pre-Order on WhatsApp</a>
            </div>
        </div>
    </section>
    @endunless

    @if ($builder)
    <!-- Builder -->
    <section id="build" aria-labelledby="build-title">
        <div class="wrap">
            <div class="head">
                <span class="eyebrow">Fully custom</span>
                <h2 id="build-title">Build Your Bouquet</h2>
                <p>Tap + on any flower to add it, or start from a design above. Your total updates as you go.</p>
            </div>

            <div class="builder">
                <div class="flowers">
                    @foreach ($flowers as $i => $f)
                        <article class="flower {{ $f['available'] ? '' : 'sold' }}" data-i="{{ $i }}">
                            <div class="img" style="background-color:{{ $f['color'] }}; @if ($f['image']) background-image:url('{{ asset('images/flowers/'.$f['image']) }}') @endif">
                                @unless ($f['image']) 🌸 @endunless
                            </div>
                            <div class="info">
                                <h3>{{ $f['name'] }}</h3>
                                <span class="price">Rp {{ number_format($f['price'], 0, ',', '.') }} / stem</span>
                                <span class="note">{{ $f['note'] }}</span>
                                @if ($f['available'])
                                    <div class="stepper">
                                        <button type="button" data-act="minus" aria-label="Remove one {{ $f['name'] }}">−</button>
                                        <output>0</output>
                                        <button type="button" data-act="plus" aria-label="Add one {{ $f['name'] }}">+</button>
                                    </div>
                                @else
                                    <span class="sold-tag">Sold out</span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="summary" aria-live="polite">
                    <h3>Your Bouquet <span class="size" id="size" hidden></span></h3>
                    <p class="occasion" id="occasion" hidden></p>
                    <p class="empty" id="empty">No flowers yet. Add some or pick a design above.</p>
                    <ul class="lines" id="lines"></ul>

                    <fieldset>
                        <legend>Wrapping</legend>
                        @foreach ($wrappings as $w => $wrap)
                            <label class="opt">
                                <span><input type="radio" name="wrapping" value="{{ $w }}" @checked($w === 0)>{{ $wrap['name'] }}</span>
                                <span>Rp {{ number_format($wrap['price'], 0, ',', '.') }}</span>
                            </label>
                        @endforeach
                    </fieldset>

                    <label for="date">Pickup / delivery date</label>
                    <input type="date" id="date">

                    <label for="note">Card message / notes</label>
                    <textarea id="note" placeholder="Optional"></textarea>

                    <div class="total"><span>Total</span><strong id="total">Rp 0</strong></div>
                    <p class="hint" id="hint"></p>
                    <a href="{{ $preorderUrl }}" id="send" class="btn btn-solid" aria-disabled="true" target="_blank" rel="noopener">Send Pre-Order</a>
                    <button type="button" class="clear" id="clear">Clear bouquet</button>
                </aside>
            </div>
        </div>
    </section>

    @endif

    <section id="how" class="how">
        <div class="wrap">
            <div class="head" style="margin-bottom:36px">
                <span class="eyebrow">Simple &amp; personal</span>
                <h2>How It Works</h2>
            </div>
            <div class="steps">
                @if ($builder)
                    <div class="step"><b>01</b><h3>Pick your flowers</h3><p>Add as many stems of each flower as you like.</p></div>
                    <div class="step"><b>02</b><h3>Pre-Order</h3><p>Choose wrapping, a date, and send us your bouquet.</p></div>
                @else
                    <div class="step"><b>01</b><h3>Browse</h3><p>Pick a design or tell us the flowers you love.</p></div>
                    <div class="step"><b>02</b><h3>Message us</h3><p>Pre-order on WhatsApp with your date and details.</p></div>
                @endif
                <div class="step"><b>03</b><h3>Enjoy</h3><p>We arrange it by hand, ready for pickup or delivery on your day.</p></div>
            </div>
        </div>
    </section>

    <section aria-labelledby="quotes-title">
        <div class="wrap">
            <div class="head">
                <span class="eyebrow">In bloom</span>
                <h2 id="quotes-title">Words on Flowers</h2>
            </div>
            <div class="quotes">
                @foreach ($testimonials as $t)
                    <div class="quote"><q>{{ $t['quote'] }}</q><cite>— {{ $t['name'] }}</cite></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="story" aria-labelledby="story-title">
        <div class="in">
            <span class="eyebrow">Our studio</span>
            <h2 id="story-title">{{ config('shop.story_title') }}</h2>
            <p>{{ config('shop.story_text') }}</p>
            <a href="{{ $orderHref }}" {!! $orderAttrs !!} class="btn btn-gold" style="margin-top:8px">{{ $builder ? 'Start your bouquet' : 'Pre-order on WhatsApp' }}</a>
        </div>
    </section>

    <section style="padding-bottom:40px">
        <div class="wrap">
            <div class="info-grid">
                @foreach (config('shop.info') as $item)
                    <div class="info-item"><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="faq" style="padding-top:40px">
        <div class="wrap">
            <div class="head">
                <span class="eyebrow">Good to know</span>
                <h2>Questions</h2>
            </div>
            <div class="faq">
                @foreach (config('shop.faq') as $item)
                    <details><summary>{{ $item['q'] }}</summary><p>{{ $item['a'] }}</p></details>
                @endforeach
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="wrap">
            <div class="row">
                <div>
                    <span style="display:flex; align-items:center; gap:14px">
                        <span class="badge"><img src="{{ asset(config('shop.logo')) }}" alt="" width="56" height="56"></span>
                        <span class="brand">{{ $shop }}</span>
                    </span>
                    @if (config('shop.location'))
                        <p class="loc">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            Find us at {{ config('shop.location') }}
                        </p>
                    @endif
                </div>
                <div class="soc">
                    @if (config('shop.facebook_url'))
                        <a href="{{ config('shop.facebook_url') }}" class="circle" aria-label="Facebook" target="_blank" rel="noopener">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v6h4v-6h3l1-4h-4V8z"/></svg>
                        </a>
                    @endif
                    @if (config('shop.instagram_url'))
                        <a href="{{ config('shop.instagram_url') }}" class="circle" aria-label="Instagram {{ $instagram }}" target="_blank" rel="noopener">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="5"/><circle cx="12" cy="12" r="3.6"/><circle cx="17" cy="7" r="0.6" fill="currentColor"/></svg>
                        </a>
                    @endif
                    <a href="{{ $waUrl }}" class="tel" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>
                        {{ $phone }}
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @if ($builder)
    <div class="mbar" id="bar">
        <div><strong id="barCount">0 stems</strong><span id="barTotal">Rp 0</span></div>
        <a href="{{ $preorderUrl }}" id="barSend" class="btn btn-solid" target="_blank" rel="noopener">Send Pre-Order</a>
    </div>

    <script>
        /* ---------- bouquet builder ---------- */
        (function () {
            var flowers = @json($flowers);
            var wrappings = @json($wrappings);
            var shop = @json($shop);
            var baseUrl = @json($preorderUrl);
            var minStems = @json(config('shop.min_stems'));
            var maxStems = @json(config('shop.max_stems'));
            var sizes = @json(config('shop.sizes'));
            var qty = flowers.map(function () { return 0; });
            var occasion = '';

            var sizeEl = document.getElementById('size');
            var hintEl = document.getElementById('hint');
            var barEl = document.getElementById('bar');
            var barSend = document.getElementById('barSend');
            var occEl = document.getElementById('occasion');
            var linesEl = document.getElementById('lines');
            var emptyEl = document.getElementById('empty');
            var totalEl = document.getElementById('total');
            var sendEl = document.getElementById('send');
            var dateEl = document.getElementById('date');
            var noteEl = document.getElementById('note');
            var navCount = document.getElementById('navCount');

            function rp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
            function wrapIndex() {
                var c = document.querySelector('input[name=wrapping]:checked');
                return c ? parseInt(c.value, 10) : 0;
            }
            function totalStems() { return qty.reduce(function (a, b) { return a + b; }, 0); }

            function render() {
                var total = 0, count = 0, lines = [], html = '';
                qty.forEach(function (q, i) {
                    if (!q) return;
                    var sub = q * flowers[i].price;
                    total += sub; count += q;
                    lines.push(q + 'x ' + flowers[i].name + ' (' + rp(sub) + ')');
                    html += '<li><span>' + q + ' × ' + flowers[i].name + '</span><span>' + rp(sub) + '</span></li>';
                });
                var w = wrappings[wrapIndex()];
                if (count) total += w.price;

                linesEl.innerHTML = html;
                emptyEl.style.display = count ? 'none' : '';
                totalEl.textContent = rp(total);
                navCount.textContent = count;
                occEl.hidden = !(occasion && count);
                occEl.textContent = occasion ? 'For: ' + occasion : '';

                document.querySelectorAll('.flower').forEach(function (card) {
                    var i = +card.dataset.i;
                    card.classList.toggle('picked', qty[i] > 0);
                    var out = card.querySelector('output');
                    if (out) out.textContent = qty[i];
                });

                var ok = count >= minStems;
                var sizeName = '';
                sizes.forEach(function (s) { if (count >= s.from) sizeName = s.name; });
                sizeEl.hidden = !count;
                sizeEl.textContent = sizeName;
                hintEl.textContent = (!count || ok) ? '' : 'Add ' + (minStems - count) + ' more stem' + (minStems - count > 1 ? 's' : '') + ' (minimum ' + minStems + ').';

                barEl.classList.toggle('show', count > 0);
                document.getElementById('barCount').textContent = count + ' stem' + (count === 1 ? '' : 's') + (ok ? '' : ' · min ' + minStems);
                document.getElementById('barTotal').textContent = rp(total);
                barSend.setAttribute('aria-disabled', ok ? 'false' : 'true');
                sendEl.setAttribute('aria-disabled', ok ? 'false' : 'true');
                if (!ok) { sendEl.href = baseUrl; barSend.href = baseUrl; return; }

                var msg = 'Hi ' + shop + ', I want to pre-order a custom bouquet:\n' +
                    lines.map(function (l) { return '- ' + l; }).join('\n') + '\n' +
                    (occasion ? 'Occasion: ' + occasion + '\n' : '') +
                    'Size: ' + sizeName + ' (' + count + ' stems)\n' +
                    'Wrapping: ' + w.name + '\n' +
                    (dateEl.value ? 'Date: ' + dateEl.value + '\n' : '') +
                    (noteEl.value.trim() ? 'Note: ' + noteEl.value.trim() + '\n' : '') +
                    'Total: ' + rp(total);
                sendEl.href = baseUrl + (baseUrl.indexOf('?') > -1 ? '&' : '?') + 'text=' + encodeURIComponent(msg);
                barSend.href = sendEl.href;
            }

            // used by the design carousel and occasion tiles
            window.Bouquet = {
                apply: function (mix, occ) {
                    qty = flowers.map(function (f) { return mix[f.name] && f.available ? mix[f.name] : 0; });
                    occasion = occ || '';
                    render();
                    var target = document.getElementById('build');
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            document.querySelectorAll('.flower').forEach(function (card) {
                card.addEventListener('click', function (e) {
                    var b = e.target.closest('button[data-act]');
                    if (!b) return;
                    var i = +card.dataset.i;
                    var d = b.dataset.act === 'plus' ? 1 : -1;
                    if (d > 0 && totalStems() >= maxStems) return;
                    qty[i] = Math.max(0, qty[i] + d);
                    render();
                });
            });
            barSend.addEventListener('click', function (e) { if (barSend.getAttribute('aria-disabled') === 'true') e.preventDefault(); });
            sendEl.addEventListener('click', function (e) { if (sendEl.getAttribute('aria-disabled') === 'true') e.preventDefault(); });
            document.querySelectorAll('input[name=wrapping]').forEach(function (r) { r.addEventListener('change', render); });
            dateEl.addEventListener('input', render);
            noteEl.addEventListener('input', render);
            dateEl.min = new Date().toISOString().slice(0, 10);
            document.getElementById('clear').addEventListener('click', function () {
                qty = qty.map(function () { return 0; });
                occasion = '';
                render();
            });
            render();
        })();
    </script>

    @endif

    <script>
        /* ---------- design carousel + occasion tiles ---------- */
        (function () {
            var C = @json($carousel);     // one slide per bouquet
            var S = @json($starters);     // starters only (occasion tiles point into this list)
            var O = @json($occasions);
            var baseUrl = @json($preorderUrl);
            var shop = @json($shop);

            // No builder: send the choice straight to WhatsApp.
            function whatsapp(text) {
                var url = baseUrl + (baseUrl.indexOf('?') > -1 ? '&' : '?') + 'text=' + encodeURIComponent(text);
                window.open(url, '_blank', 'noopener');
            }

            var track = document.getElementById('track');
            var dotsEl = document.getElementById('dots');
            var countEl = document.getElementById('count');
            var fillEl = document.getElementById('fill');
            var n = C.length;
            var i = 0;
            var ticking = false;

            C.forEach(function (s, j) {
                var b = document.createElement('button');
                b.type = 'button';
                b.setAttribute('aria-label', 'Show ' + s.name);
                b.innerHTML = '<i></i>';
                b.addEventListener('click', function () { go(j); });
                dotsEl.appendChild(b);
            });

            // reflect the slide currently snapped into view
            function sync() {
                ticking = false;
                var w = track.clientWidth || 1;
                i = Math.max(0, Math.min(n - 1, Math.round(track.scrollLeft / w)));
                Array.prototype.forEach.call(dotsEl.children, function (b, j) { b.classList.toggle('on', j === i); });
                countEl.textContent = String(i + 1).padStart(2, '0') + ' / ' + String(n).padStart(2, '0');
                fillEl.style.width = ((i + 1) / n * 100).toFixed(2) + '%';
            }

            // one swipe (or arrow tap) moves exactly one bouquet; the ends wrap around
            function go(j) {
                j = (j + n) % n;
                track.scrollTo({ left: j * track.clientWidth, behavior: 'smooth' });
            }

            track.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(sync); } }, { passive: true });
            window.addEventListener('resize', function () { track.scrollTo({ left: i * track.clientWidth }); sync(); });
            document.getElementById('prev').addEventListener('click', function () { go(i - 1); });
            document.getElementById('next').addEventListener('click', function () { go(i + 1); });
            track.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowRight') { e.preventDefault(); go(i + 1); }
                if (e.key === 'ArrowLeft') { e.preventDefault(); go(i - 1); }
            });

            document.querySelectorAll('.ask').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var b = C[+btn.dataset.i];
                    whatsapp('Hi ' + shop + ', I am interested in the "' + b.name + '" bouquet. Could you tell me more?');
                });
            });

            document.querySelectorAll('.occ').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var o = O[+btn.dataset.o];
                    if (window.Bouquet) window.Bouquet.apply(S[o.starter].mix, o.name);
                    else whatsapp('Hi ' + shop + ', I am looking for a bouquet for a ' + o.name.toLowerCase() + '. Could you help me choose?');
                });
            });

            sync();
        })();
    </script>

    <script>
        /* ---------- mobile menu ---------- */
        (function () {
            var btn = document.getElementById('burger');
            var menu = document.getElementById('mmenu');
            if (!btn || !menu) return;
            function setOpen(open) {
                menu.hidden = !open;
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                btn.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
            }
            btn.addEventListener('click', function () { setOpen(menu.hidden); });
            menu.addEventListener('click', function (e) { if (e.target.closest('a')) setOpen(false); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
            window.addEventListener('resize', function () { if (window.innerWidth > 860) setOpen(false); });
        })();
    </script>

    <script>
        /* ---------- scroll fade ---------- */
        (function () {
            var sel = '.f-head, .head, .occ, .flower, .step, .quote, .story .in > *, .info-item, .faq details, footer .row > *';
            var els = Array.prototype.slice.call(document.querySelectorAll(sel));
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            // Fade-in only: content softly appears as it rises into view from the bottom edge,
            // and stays fully visible once it is on screen (nothing fades out at the top while reading).
            var ZONE = 0.22;   // fade band = 22% of viewport height at the bottom edge
            var SHIFT = 14;    // px drift while fading in
            var EASE = 0.1;    // 0-1: lower = slower, silkier catch-up toward the target
            var running = false;

            function curve(t) { return t * t * t * (t * (t * 6 - 15) + 10); } // smootherstep
            function clamp(v) { return v < 0 ? 0 : v > 1 ? 1 : v; }

            // per-element current values, eased toward the scroll-driven target every frame
            var st = els.map(function (el) { return { el: el, o: 1, y: 0, init: false }; });

            function frame() {
                var vh = window.innerHeight;
                var zone = vh * ZONE;
                // near the page ends, extend the visible area so the first/last items never stay faded
                var remaining = document.documentElement.scrollHeight - (window.scrollY + vh);
                var extra = Math.max(0, zone - remaining);
                var moving = false;

                for (var k = 0; k < st.length; k++) {
                    var s = st[k];
                    var r = s.el.getBoundingClientRect();
                    var c = r.top + r.height / 2;
                    var bottom = curve(clamp((vh + extra - c) / zone));
                    var to = bottom;
                    var ty = (1 - bottom) * SHIFT;

                    if (!s.init) { s.o = to; s.y = ty; s.init = true; }   // no animation on first paint
                    else {
                        s.o += (to - s.o) * EASE;
                        s.y += (ty - s.y) * EASE;
                    }
                    if (Math.abs(to - s.o) > 0.002 || Math.abs(ty - s.y) > 0.05) moving = true;
                    else { s.o = to; s.y = ty; }

                    s.el.style.opacity = s.o.toFixed(3);
                    s.el.style.translate = '0 ' + s.y.toFixed(2) + 'px';
                }

                if (moving) requestAnimationFrame(frame); else running = false;
            }

            function kick() { if (!running) { running = true; requestAnimationFrame(frame); } }

            els.forEach(function (el) { el.classList.add('reveal'); });
            window.addEventListener('scroll', kick, { passive: true });
            window.addEventListener('resize', kick);
            window.addEventListener('load', kick);
            kick();
        })();
    </script>
</body>
</html>
