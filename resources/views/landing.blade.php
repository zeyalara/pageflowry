<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PAGEFLOWRY – Creator Workflow System</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --blue: #5C97F5; --blue-dark: #4A84E0; --blue-deep: #2E5DB3;
      --soft: #EAF2FF; --dark: #1A2740; --muted: #6B7E95; --white: #fff;
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Sora', sans-serif; background: #fff; color: var(--dark); overflow-x: hidden; }

    /* CURSOR */
    .cursor-glow {
      width: 320px; height: 320px; border-radius: 50%;
      background: radial-gradient(circle, rgba(92,151,245,0.1) 0%, transparent 70%);
      position: fixed; pointer-events: none;
      transform: translate(-50%,-50%); z-index: 9999;
    }

    /* NAVBAR */
    nav {
      position: fixed; top: 0; left: 0; right: 0; z-index: 200;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 64px; height: 72px;
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(92,151,245,0.1);
      transition: all 0.3s;
    }
    nav.scrolled { height: 60px; box-shadow: 0 4px 30px rgba(92,151,245,0.1); }
    .nav-logo {
      display: flex; align-items: center; gap: 10px;
      font-size: 1.2rem; font-weight: 800; color: var(--blue);
      letter-spacing: -0.5px; text-decoration: none;
    }
    .logo-box {
      width: 36px; height: 36px; border-radius: 10px;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      display: flex; align-items: center; justify-content: center;
    }
    .logo-box svg { width: 18px; height: 18px; }
    .nav-logo em { color: var(--dark); font-style: normal; }
    .nav-links { display: flex; gap: 36px; list-style: none; }
    .nav-links a {
      text-decoration: none; color: var(--muted);
      font-size: 0.875rem; font-weight: 500;
      position: relative; transition: color 0.2s;
    }
    .nav-links a::after {
      content: ''; position: absolute; bottom: -4px; left: 0;
      width: 0; height: 2px; background: var(--blue);
      border-radius: 2px; transition: width 0.3s;
    }
    .nav-links a:hover { color: var(--blue); }
    .nav-links a:hover::after { width: 100%; }
    .btn-login {
      display: flex; align-items: center; gap: 8px;
      background: var(--dark); color: #fff;
      padding: 10px 24px; border-radius: 100px;
      font-size: 0.875rem; font-weight: 600;
      text-decoration: none; transition: all 0.25s;
    }
    .btn-login:hover { background: var(--blue); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(92,151,245,0.4); }

    /* HERO */
    .hero {
      min-height: 100vh;
      display: grid; grid-template-columns: 1fr 1fr;
      align-items: center; padding: 100px 64px 60px;
      position: relative; overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(92,151,245,0.13) 1px, transparent 1px);
      background-size: 30px 30px;
      pointer-events: none; z-index: 0;
      mask-image: radial-gradient(ellipse 80% 80% at 60% 40%, black 30%, transparent 100%);
    }
    .blob1 {
      position: absolute; top: -120px; right: -120px;
      width: 600px; height: 600px; border-radius: 50%;
      background: radial-gradient(circle, rgba(92,151,245,0.14) 0%, transparent 70%);
      pointer-events: none;
    }
    .blob2 {
      position: absolute; bottom: -150px; left: -80px;
      width: 450px; height: 450px; border-radius: 50%;
      background: radial-gradient(circle, rgba(74,132,224,0.08) 0%, transparent 70%);
      pointer-events: none;
    }
    .hero-left { position: relative; z-index: 1; }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--soft); color: var(--blue);
      font-size: 0.7rem; font-weight: 700; letter-spacing: 1.5px;
      padding: 8px 18px; border-radius: 100px; margin-bottom: 26px;
      border: 1px solid rgba(92,151,245,0.2); text-transform: uppercase;
      animation: pulseRing 2.5s ease-in-out infinite;
    }
    @keyframes pulseRing {
      0%,100% { box-shadow: 0 0 0 0 rgba(92,151,245,0.2); }
      50% { box-shadow: 0 0 0 8px rgba(92,151,245,0); }
    }
    .bdot { width: 7px; height: 7px; border-radius: 50%; background: var(--blue); animation: blink 1.5s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }
    .hero-title {
      font-size: clamp(2.3rem, 4.5vw, 3.5rem);
      font-weight: 800; line-height: 1.1; letter-spacing: -2px;
      margin-bottom: 22px; color: var(--dark);
    }
    .grad-text {
      background: linear-gradient(135deg, var(--blue) 0%, #85B8FF 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .hero-desc {
      font-family: 'DM Sans', sans-serif;
      font-size: 1rem; color: var(--muted); line-height: 1.8;
      margin-bottom: 38px; max-width: 460px;
    }
    .hero-cta { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; }
    .btn-primary {
      display: inline-flex; align-items: center; gap: 10px;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      color: #fff; padding: 14px 32px; border-radius: 100px;
      font-weight: 700; font-size: 0.95rem; text-decoration: none;
      transition: all 0.3s; box-shadow: 0 8px 28px rgba(92,151,245,0.4);
    }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(92,151,245,0.5); }
    .btn-ghost {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--dark); font-weight: 600; font-size: 0.9rem;
      text-decoration: none; padding: 14px 4px;
      transition: all 0.2s; background: none; border: none; cursor: pointer;
    }
    .btn-ghost:hover { color: var(--blue); gap: 14px; }
    .hero-stats {
      display: flex; gap: 36px; margin-top: 48px;
      padding-top: 32px; border-top: 1px solid rgba(92,151,245,0.12);
    }
    .stat-num { font-size: 1.9rem; font-weight: 800; color: var(--dark); letter-spacing: -1px; }
    .stat-lbl { font-size: 0.78rem; color: var(--muted); font-family: 'DM Sans', sans-serif; margin-top: 2px; }

    /* HERO RIGHT – IMAGE */
    .hero-right {
      position: relative; z-index: 1;
      display: flex; justify-content: center; align-items: center;
    }
    .img-wrap { position: relative; width: 100%; max-width: 520px; }
    .hero-img {
      width: 100%; border-radius: 24px;
      animation: floatImg 4s ease-in-out infinite alternate;
      filter: drop-shadow(0 24px 50px rgba(92,151,245,0.2));
    }
    @keyframes floatImg {
      0%   { transform: translateY(0) rotate(-0.5deg); }
      100% { transform: translateY(-16px) rotate(0.5deg); }
    }
    .fbadge {
      position: absolute; background: #fff; border-radius: 16px;
      padding: 10px 16px; box-shadow: 0 8px 28px rgba(0,0,0,0.1);
      display: flex; align-items: center; gap: 10px;
      border: 1px solid rgba(92,151,245,0.1);
      animation: floatB 3.5s ease-in-out infinite alternate;
    }
    .fbadge .fi { font-size: 1.3rem; }
    .fbadge .ft { font-size: 0.72rem; font-weight: 700; color: var(--dark); line-height: 1.3; }
    .fbadge .fs { font-size: 0.65rem; color: var(--muted); font-family: 'DM Sans', sans-serif; }
    .fb1 { top: 8%; left: -12%; animation-delay: 0s; }
    .fb2 { bottom: 12%; right: -10%; animation-delay: 0.9s; }
    .fb3 { top: 52%; left: -14%; animation-delay: 1.6s; }
    @keyframes floatB { 0%{transform:translateY(0)} 100%{transform:translateY(-10px)} }

    /* CARDS */
    .cards-sec { background: var(--soft); padding: 80px 64px; }
    .cards-grid {
      max-width: 1200px; margin: 0 auto;
      display: grid; grid-template-columns: repeat(4,1fr); gap: 20px;
    }
    .qcard {
      background: #fff; border-radius: 24px; padding: 32px 26px;
      border: 1px solid rgba(92,151,245,0.08);
      transition: all 0.35s cubic-bezier(0.34,1.56,0.64,1);
      position: relative; overflow: hidden; cursor: default;
    }
    .qcard::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0;
      height: 3px; background: linear-gradient(90deg, var(--blue), #85B8FF);
      transform: scaleX(0); transform-origin: left; transition: transform 0.35s;
    }
    .qcard:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(92,151,245,0.18); }
    .qcard:hover::before { transform: scaleX(1); }
    .qcard-n { font-size: 0.68rem; font-weight: 700; color: rgba(92,151,245,0.35); letter-spacing: 2px; margin-bottom: 14px; }
    .qcard-i { font-size: 2rem; margin-bottom: 14px; display: block; filter: drop-shadow(0 4px 8px rgba(92,151,245,0.2)); }
    .qcard h3 { font-size: 0.98rem; font-weight: 700; margin-bottom: 10px; }
    .qcard p { font-family: 'DM Sans', sans-serif; font-size: 0.875rem; color: var(--muted); line-height: 1.65; }
    .qcard-a {
      display: inline-flex; align-items: center; gap: 6px;
      color: var(--blue); font-size: 0.8rem; font-weight: 600;
      margin-top: 18px; text-decoration: none; transition: gap 0.2s;
    }
    .qcard:hover .qcard-a { gap: 12px; }

    /* SECTION */
    .sec { padding: 100px 64px; }
    .sec-inner { max-width: 1200px; margin: 0 auto; }
    .lbl {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--blue); font-size: 0.7rem; font-weight: 700;
      letter-spacing: 2px; text-transform: uppercase; margin-bottom: 14px;
    }
    .lbl::before { content: ''; width: 20px; height: 2px; background: var(--blue); border-radius: 2px; }
    .sec-title { font-size: clamp(1.8rem, 3vw, 2.6rem); font-weight: 800; letter-spacing: -1px; line-height: 1.15; margin-bottom: 18px; }
    .sec-desc { font-family: 'DM Sans', sans-serif; font-size: 1rem; color: var(--muted); line-height: 1.8; max-width: 520px; }

    /* WORKFLOW */
    .wf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
    .flow-item {
      display: flex; gap: 18px; align-items: flex-start;
      padding: 18px 0; border-bottom: 1px solid rgba(92,151,245,0.08);
      transition: all 0.2s; cursor: default;
    }
    .flow-item:last-child { border-bottom: none; }
    .flow-item:hover { padding-left: 10px; }
    .fn {
      width: 38px; height: 38px; border-radius: 12px;
      background: var(--soft); display: flex; align-items: center; justify-content: center;
      font-size: 0.78rem; font-weight: 800; color: var(--blue);
      flex-shrink: 0; transition: all 0.2s;
    }
    .flow-item:hover .fn { background: var(--blue); color: #fff; }
    .fc h4 { font-size: 0.88rem; font-weight: 700; margin-bottom: 3px; }
    .fc p { font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: var(--muted); }
    .btn-ol {
      display: inline-flex; align-items: center; gap: 10px;
      border: 2px solid var(--blue); color: var(--blue);
      padding: 12px 28px; border-radius: 100px;
      font-weight: 700; font-size: 0.875rem; text-decoration: none;
      margin-top: 30px; transition: all 0.3s;
    }
    .btn-ol:hover { background: var(--blue); color: #fff; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(92,151,245,0.35); }

    /* WHY */
    .why-sec { background: var(--soft); }
    .why-hd { text-align: center; margin-bottom: 52px; }
    .why-hd .lbl { justify-content: center; }
    .why-hd .lbl::before { display: none; }
    .why-hd .sec-desc { margin: 0 auto; }
    .why-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }
    .why-card {
      background: #fff; border-radius: 20px; padding: 28px;
      display: flex; gap: 18px;
      border: 1px solid rgba(92,151,245,0.06);
      transition: all 0.3s;
    }
    .why-card:hover { border-color: rgba(92,151,245,0.2); box-shadow: 0 12px 40px rgba(92,151,245,0.12); transform: translateY(-4px); }
    .wi { width: 46px; height: 46px; border-radius: 14px; background: var(--soft); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .why-card h4 { font-size: 0.93rem; font-weight: 700; margin-bottom: 7px; }
    .why-card p { font-family: 'DM Sans', sans-serif; font-size: 0.85rem; color: var(--muted); line-height: 1.65; }

    /* COLLAB */
    .collab-wrap { background: #fff; padding: 100px 64px; }
    .collab-box {
      max-width: 1200px; margin: 0 auto;
      background: linear-gradient(135deg, var(--dark) 0%, #1E3A6E 100%);
      border-radius: 32px; padding: 80px 64px; text-align: center;
      position: relative; overflow: hidden;
    }
    .collab-box::before {
      content: ''; position: absolute; top: -100px; right: -100px;
      width: 400px; height: 400px; border-radius: 50%;
      background: radial-gradient(circle, rgba(92,151,245,0.2) 0%, transparent 70%);
    }
    .collab-box::after {
      content: ''; position: absolute; bottom: -80px; left: -80px;
      width: 300px; height: 300px; border-radius: 50%;
      background: radial-gradient(circle, rgba(92,151,245,0.12) 0%, transparent 70%);
    }
    .collab-in { position: relative; z-index: 1; max-width: 680px; margin: 0 auto; }
    .collab-box .lbl { color: rgba(92,151,245,0.65); justify-content: center; }
    .collab-box .lbl::before { background: rgba(92,151,245,0.4); }
    .collab-box .sec-title { color: #fff; }
    .collab-box .sec-desc { color: rgba(255,255,255,0.65); margin: 0 auto 32px; }
    .collab-chips { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-bottom: 36px; }
    .chip {
      background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
      color: rgba(255,255,255,0.85); border-radius: 100px;
      padding: 8px 18px; font-size: 0.8rem; font-weight: 500;
    }
    .btn-wh {
      display: inline-flex; align-items: center; gap: 10px;
      background: #fff; color: var(--dark); padding: 14px 34px;
      border-radius: 100px; font-weight: 700; font-size: 0.9rem;
      text-decoration: none; transition: all 0.3s;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }
    .btn-wh:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,0.3); }

    /* PERFORMANCE */
    .perf-sec { background: #fff; }
    .perf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
    .metric-g { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .mbox {
      background: var(--soft); border-radius: 20px; padding: 22px;
      transition: all 0.3s;
    }
    .mbox:hover { background: var(--blue); transform: translateY(-5px); box-shadow: 0 12px 30px rgba(92,151,245,0.3); }
    .mbox:hover .mnum, .mbox:hover .mlbl { color: #fff; }
    .mico { font-size: 1.3rem; margin-bottom: 10px; }
    .mnum { font-size: 1.8rem; font-weight: 800; color: var(--dark); letter-spacing: -1px; line-height: 1; margin-bottom: 4px; transition: color 0.3s; }
    .mlbl { font-family: 'DM Sans', sans-serif; font-size: 0.75rem; color: var(--muted); transition: color 0.3s; }
    .kpi-card { background: var(--soft); border-radius: 20px; padding: 22px; margin-top: 14px; }
    .kpi-ttl { font-size: 0.82rem; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .kpi-it { margin-bottom: 14px; }
    .kpi-it:last-child { margin-bottom: 0; }
    .kpi-row { display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--muted); font-family: 'DM Sans', sans-serif; margin-bottom: 6px; }
    .kpi-pct { font-weight: 700; color: var(--blue); }
    .kpi-tr { height: 8px; background: rgba(92,151,245,0.15); border-radius: 100px; overflow: hidden; }
    .kpi-fi { height: 100%; border-radius: 100px; background: linear-gradient(90deg, var(--blue), #85B8FF); transition: width 1.5s cubic-bezier(0.4,0,0.2,1); }

    /* ROLES */
    .roles-sec { background: var(--soft); }
    .roles-hd { text-align: center; margin-bottom: 52px; }
    .roles-hd .lbl { justify-content: center; }
    .roles-hd .lbl::before { display: none; }
    .roles-grid { max-width: 980px; margin: 0 auto; display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
    .rcard {
      background: #fff; border-radius: 28px; padding: 40px 28px; text-align: center;
      border: 1px solid rgba(92,151,245,0.08);
      transition: all 0.35s cubic-bezier(0.34,1.56,0.64,1);
    }
    .rcard:hover { transform: translateY(-10px); box-shadow: 0 24px 60px rgba(92,151,245,0.2); border-color: rgba(92,151,245,0.2); }
    .remi { font-size: 3rem; margin-bottom: 16px; display: block; }
    .rcard h3 { font-size: 1.05rem; font-weight: 800; margin-bottom: 20px; }
    .rlist { list-style: none; text-align: left; }
    .rlist li {
      font-family: 'DM Sans', sans-serif; font-size: 0.85rem; color: var(--muted);
      padding: 8px 0; border-bottom: 1px solid rgba(92,151,245,0.06);
      display: flex; align-items: center; gap: 10px;
    }
    .rlist li:last-child { border-bottom: none; }
    .ck {
      width: 18px; height: 18px; border-radius: 50%; background: var(--soft);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem; color: var(--blue); flex-shrink: 0;
    }
    .roles-cta { text-align: center; margin-top: 48px; }

    /* ACADEMIC */
    .acad-sec { background: #fff; }
    .acad-box {
      max-width: 880px; margin: 0 auto;
      background: var(--soft); border-radius: 32px; padding: 64px;
      text-align: center; border: 1px solid rgba(92,151,245,0.1);
    }
    .acad-tag {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--blue); color: #fff;
      font-size: 0.68rem; font-weight: 700; letter-spacing: 1.5px;
      padding: 8px 20px; border-radius: 100px; margin-bottom: 26px;
      text-transform: uppercase;
    }
    .acad-box .sec-desc { margin: 0 auto 10px; }
    .dev-row { display: flex; gap: 16px; justify-content: center; margin-top: 36px; }
    .dcard {
      background: #fff; border-radius: 20px; padding: 24px 26px;
      flex: 1; max-width: 230px;
      box-shadow: 0 4px 24px rgba(92,151,245,0.1);
      border: 1px solid rgba(92,151,245,0.08); transition: all 0.3s;
    }
    .dcard:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(92,151,245,0.18); }
    .dav {
      width: 52px; height: 52px; border-radius: 50%;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      color: #fff; font-weight: 800; font-size: 1.2rem;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 14px;
    }
    .dcard h4 { font-size: 0.88rem; font-weight: 700; margin-bottom: 6px; }
    .dcard p { font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: var(--muted); }
    .school-chip {
      display: inline-flex; align-items: center; gap: 10px;
      background: #fff; border-radius: 100px;
      padding: 12px 26px; margin-top: 30px;
      box-shadow: 0 4px 20px rgba(92,151,245,0.1);
      font-size: 0.875rem; font-weight: 600;
      border: 1px solid rgba(92,151,245,0.1);
    }

    /* FOOTER */
    footer {
      background: var(--dark); padding: 48px 64px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .f-logo { font-size: 1.1rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
    .f-logo span { color: var(--blue); }
    footer p { font-family: 'DM Sans', sans-serif; font-size: 0.82rem; color: rgba(255,255,255,0.4); }
    .f-links { display: flex; gap: 24px; }
    .f-links a { color: rgba(255,255,255,0.45); text-decoration: none; font-size: 0.82rem; font-family: 'DM Sans', sans-serif; transition: color 0.2s; }
    .f-links a:hover { color: var(--blue); }

    /* REVEAL */
    .rv { opacity: 0; transform: translateY(36px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .rv.d1 { transition-delay: 0.1s; }
    .rv.d2 { transition-delay: 0.2s; }
    .rv.d3 { transition-delay: 0.3s; }
    .rv.vis { opacity: 1; transform: none; }

    @media(max-width:1024px){
      nav,.hero,.cards-sec,.sec,.collab-wrap,.perf-sec,.acad-sec{padding-left:28px;padding-right:28px;}
      .hero{grid-template-columns:1fr;gap:60px;text-align:center;}
      .hero-left{display:flex;flex-direction:column;align-items:center;}
      .hero-desc,.sec-desc{margin-left:auto;margin-right:auto;}
      .wf-grid,.perf-grid{grid-template-columns:1fr;gap:48px;}
      .cards-grid{grid-template-columns:1fr 1fr;}
      .roles-grid{grid-template-columns:1fr;max-width:380px;}
      .why-grid{grid-template-columns:1fr;}
      .collab-box{padding:52px 28px;}
      footer{flex-direction:column;gap:16px;text-align:center;}
      .fb1,.fb2,.fb3{display:none;}
    }
  </style>
</head>
<body>

<div class="cursor-glow" id="cg"></div>

<!-- NAVBAR -->
<nav id="nav">
  <a href="#" class="nav-logo">
    <div class="logo-box">
      <svg viewBox="0 0 18 18" fill="none">
        <rect x="1" y="1" width="7" height="7" rx="2" fill="white"/>
        <rect x="10" y="1" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
        <rect x="1" y="10" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
        <rect x="10" y="10" width="7" height="7" rx="2" fill="white"/>
      </svg>
    </div>
    PAGE<em>FLOWRY</em>
  </a>
  <ul class="nav-links">
    <li><a href="#workflow">Workflow</a></li>
    <li><a href="#why">Tentang</a></li>
    <li><a href="#roles">Roles</a></li>
    <li><a href="#academic">Project</a></li>
  </ul>
  <a href="{{ route('login') }}" class="btn-login">🔐 Login</a>
</nav>

<!-- HERO -->
<section class="hero" id="home">
  <div class="blob1"></div>
  <div class="blob2"></div>

  <div class="hero-left rv">
    <div class="hero-badge"><div class="bdot"></div> Creator Workflow System</div>
    <h1 class="hero-title">
      Manage Your<br/>
      Content Workflow<br/>
      <span class="grad-text">Professionally</span>
    </h1>
    <p class="hero-desc">
      PAGEFLOWRY membantu tim mengelola proses ide, brief, produksi,
      revisi, approval hingga publish dalam satu sistem terintegrasi.
    </p>
    <div class="hero-cta">
      <a href="/login" class="btn-primary">🔐 Login ke Sistem &nbsp;→</a>
      <a href="#workflow" class="btn-ghost">Lihat Cara Kerja →</a>
    </div>
    <div class="hero-stats">
      <div><div class="stat-num" data-count="9">0</div><div class="stat-lbl">Modul Sistem</div></div>
      <div><div class="stat-num" data-count="2">0</div><div class="stat-lbl">Peran Pengguna</div></div>
      <div><div class="stat-num" data-count="100">0</div><div class="stat-lbl">% Terintegrasi</div></div>
    </div>
  </div>

  <div class="hero-right rv d2">
    <div class="img-wrap">
      {{-- Taruh file landing1.png di: public/images/landing1.png --}}
      <img class="hero-img" src="{{ asset('images/landing1.jpg') }}" alt="PAGEFLOWRY"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
      <div style="display:none;width:100%;height:380px;background:linear-gradient(135deg,#EAF2FF,#C8DCFF);border-radius:24px;align-items:center;justify-content:center;flex-direction:column;gap:12px;">
        <div style="font-size:3.5rem;">📊</div>
        <div style="font-size:0.85rem;color:#5C97F5;font-weight:700;text-align:center;padding:0 20px;">Taruh <code>landing1.png</code> di folder <code>public/images/</code></div>
      </div>
      <div class="fbadge fb1"><span class="fi">✅</span><div><div class="ft">Content Approved</div><div class="fs">Ready to Publish</div></div></div>
      <div class="fbadge fb2"><span class="fi">🚀</span><div><div class="ft">Published!</div><div class="fs">2 menit lalu</div></div></div>
      <div class="fbadge fb3"><span class="fi">📝</span><div><div class="ft">Brief Dibuat</div><div class="fs">In Production</div></div></div>
    </div>
  </div>
</section>

<!-- QUICK CARDS -->
<div class="cards-sec">
  <div class="cards-grid">
    <div class="qcard rv"><div class="qcard-n">01</div><span class="qcard-i">📂</span><h3>Brand Management</h3><p>Kelola brand dan assign creator secara terstruktur dan mudah dipantau oleh seluruh tim.</p><a href="/login" class="qcard-a">Kelola Brand →</a></div>
    <div class="qcard rv d1"><div class="qcard-n">02</div><span class="qcard-i">📝</span><h3>Content Brief</h3><p>Susun strategi, konsep, dan KPI konten dengan template yang terstruktur dan lengkap.</p><a href="/login" class="qcard-a">Buat Brief →</a></div>
    <div class="qcard rv d2"><div class="qcard-n">03</div><span class="qcard-i">🎬</span><h3>Production & Revision</h3><p>Upload versi konten dan kelola revisi secara sistematis antara admin dan creator.</p><a href="/login" class="qcard-a">Produksi →</a></div>
    <div class="qcard rv d3"><div class="qcard-n">04</div><span class="qcard-i">📊</span><h3>Analytics Monitoring</h3><p>Pantau performa dan pencapaian KPI konten secara terpusat dan mudah dipahami.</p><a href="/login" class="qcard-a">Lihat Analytics →</a></div>
  </div>
</div>

<!-- WORKFLOW -->
<section class="sec" id="workflow">
  <div class="sec-inner">
    <div class="wf-grid">
      <div class="rv">
        <div class="flow-item"><div class="fn">01</div><div class="fc"><h4>💡 Ide & Konsep</h4><p>Mulai dari gagasan awal yang akan dikembangkan menjadi konten berkualitas.</p></div></div>
        <div class="flow-item"><div class="fn">02</div><div class="fc"><h4>📝 Content Brief</h4><p>Dokumentasi strategi, target audience, hook, caption, KPI, dan visual direction.</p></div></div>
        <div class="flow-item"><div class="fn">03</div><div class="fc"><h4>🎬 Production & Upload</h4><p>Creator memproduksi dan mengupload hasil konten tiap versi (v1, v2, v3).</p></div></div>
        <div class="flow-item"><div class="fn">04</div><div class="fc"><h4>🔄 Revision</h4><p>Admin memberi catatan revisi, creator memperbaiki sesuai arahan yang jelas.</p></div></div>
        <div class="flow-item"><div class="fn">05</div><div class="fc"><h4>✅ Approval</h4><p>Admin melakukan persetujuan final — tercatat nama approver & tanggal approval.</p></div></div>
        <div class="flow-item"><div class="fn">06</div><div class="fc"><h4>🚀 Publishing</h4><p>Konten dipublish langsung atau dijadwalkan sesuai rencana distribusi.</p></div></div>
        <div class="flow-item"><div class="fn">07</div><div class="fc"><h4>📊 Analytics & Report</h4><p>Monitor performa konten dan export laporan dalam format PDF atau Excel.</p></div></div>
      </div>
      <div class="rv d2">
        <div class="lbl">Our System</div>
        <h2 class="sec-title">Structured<br/>Content Workflow</h2>
        <p class="sec-desc">PAGEFLOWRY dirancang dengan alur kerja profesional dari awal hingga akhir. Setiap konten melewati proses yang jelas, terkontrol, dan terukur.</p>
        <p class="sec-desc" style="margin-top:14px;">Tidak ada tahapan yang terlewat. Setiap revisi terdokumentasi, setiap keputusan tercatat secara sistematis.</p>
        <a href="/login" class="btn-ol">Explore System →</a>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="sec why-sec" id="why">
  <div class="sec-inner">
    <div class="why-hd rv">
      <div class="lbl">Background</div>
      <h2 class="sec-title">Why We Built PAGEFLOWRY</h2>
      <p class="sec-desc">Proses produksi konten di industri kreatif sering tidak terstruktur — komunikasi tersebar, revisi berulang tanpa dokumentasi, dan deadline terlewat tanpa monitoring.</p>
    </div>
    <div class="why-grid">
      <div class="why-card rv"><div class="wi">🔗</div><div><h4>Satu Platform Terintegrasi</h4><p>Menyatukan seluruh alur kerja konten dalam satu sistem yang mudah diakses oleh semua anggota tim.</p></div></div>
      <div class="why-card rv d1"><div class="wi">✅</div><div><h4>Kontrol Revisi & Approval</h4><p>Setiap revisi tercatat dengan catatan dan deadline. Approval tersimpan dengan nama dan tanggal.</p></div></div>
      <div class="why-card rv d1"><div class="wi">🎯</div><div><h4>Target KPI Terukur</h4><p>Setiap konten memiliki target KPI yang jelas sehingga performa dapat dievaluasi secara objektif.</p></div></div>
      <div class="why-card rv d2"><div class="wi">⚡</div><div><h4>Efisiensi Kerja Tim</h4><p>Mempermudah koordinasi antara Admin dan Content Creator dengan hak akses yang terkontrol.</p></div></div>
    </div>
  </div>
</section>

<!-- COLLAB -->
<div class="collab-wrap">
  <div class="collab-box rv">
    <div class="collab-in">
      <div class="lbl">Collaboration</div>
      <h2 class="sec-title">Full Control &<br/>Team Collaboration</h2>
      <p class="sec-desc">Admin dan Content Creator bekerja dalam satu sistem dengan kontrol akses yang jelas. Setiap proses terekam, setiap revisi terdokumentasi, setiap approval tercatat.</p>
      <div class="collab-chips">
        <span class="chip">✅ Role-based Access</span>
        <span class="chip">📋 Revision History</span>
        <span class="chip">🔐 Approval System</span>
        <span class="chip">📊 KPI Tracking</span>
      </div>
      <a href="/login" class="btn-wh">🔐 Login to System →</a>
    </div>
  </div>
</div>

<!-- PERFORMANCE -->
<section class="sec perf-sec">
  <div class="sec-inner">
    <div class="perf-grid">
      <div class="rv">
        <div class="lbl">Analytics</div>
        <h2 class="sec-title">Content Performance<br/>Tracking</h2>
        <p class="sec-desc">Pantau Views, Likes, Comments, Shares, dan Engagement Rate, serta perbandingan KPI vs Realisasi dalam satu dashboard yang sederhana dan mudah dipahami.</p>
        <a href="/login" class="btn-ol">View Analytics →</a>
      </div>
      <div class="rv d2">
        <div class="metric-g">
          <div class="mbox"><div class="mico">👁️</div><div class="mnum">24.5K</div><div class="mlbl">Total Views</div></div>
          <div class="mbox"><div class="mico">❤️</div><div class="mnum">3.2K</div><div class="mlbl">Total Likes</div></div>
          <div class="mbox"><div class="mico">💬</div><div class="mnum">412</div><div class="mlbl">Comments</div></div>
          <div class="mbox"><div class="mico">📈</div><div class="mnum">8.7%</div><div class="mlbl">Engagement Rate</div></div>
        </div>
        <div class="kpi-card">
          <div class="kpi-ttl">📊 KPI vs Realisasi</div>
          <div class="kpi-it"><div class="kpi-row"><span>Views</span><span class="kpi-pct">82%</span></div><div class="kpi-tr"><div class="kpi-fi" style="width:0" data-w="82%"></div></div></div>
          <div class="kpi-it"><div class="kpi-row"><span>Engagement</span><span class="kpi-pct">91%</span></div><div class="kpi-tr"><div class="kpi-fi" style="width:0" data-w="91%"></div></div></div>
          <div class="kpi-it"><div class="kpi-row"><span>Shares</span><span class="kpi-pct">67%</span></div><div class="kpi-tr"><div class="kpi-fi" style="width:0" data-w="67%"></div></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ROLES -->
<section class="sec roles-sec" id="roles">
  <div class="sec-inner">
    <div class="roles-hd rv">
      <div class="lbl">System Roles</div>
      <h2 class="sec-title">Siapa yang Menggunakan<br/>PAGEFLOWRY?</h2>
    </div>
    <div class="roles-grid">
      <div class="rcard rv"><span class="remi">👑</span><h3>Admin</h3><ul class="rlist"><li><span class="ck">✓</span>Mengelola semua brand</li><li><span class="ck">✓</span>Memberikan catatan revisi</li><li><span class="ck">✓</span>Approval konten final</li><li><span class="ck">✓</span>Monitoring performa</li><li><span class="ck">✓</span>Export laporan</li></ul></div>
      <div class="rcard rv d1"><span class="remi">🎥</span><h3>Content Creator</h3><ul class="rlist"><li><span class="ck">✓</span>Membuat content brief</li><li><span class="ck">✓</span>Produksi konten</li><li><span class="ck">✓</span>Upload & revisi konten</li><li><span class="ck">✓</span>Monitoring konten sendiri</li><li><span class="ck">✓</span>Publishing konten</li></ul></div>
      <div class="rcard rv d2"><span class="remi">📊</span><h3>System Monitoring</h3><ul class="rlist"><li><span class="ck">✓</span>Status tracking real-time</li><li><span class="ck">✓</span>Deadline reminder</li><li><span class="ck">✓</span>History versi konten</li><li><span class="ck">✓</span>Report export PDF/Excel</li><li><span class="ck">✓</span>KPI tracking</li></ul></div>
    </div>
    <div class="roles-cta rv"><a href="/login" class="btn-primary">🔐 Login to System →</a></div>
  </div>
</section>

<!-- ACADEMIC -->
<section class="sec acad-sec" id="academic">
  <div class="acad-box rv">
    <span class="acad-tag">🎓 Academic Project – PKL 2026</span>
    <h2 class="sec-title">Academic Project Information</h2>
    <p class="sec-desc">PAGEFLOWRY merupakan sistem yang dikembangkan sebagai bagian dari <strong>Tugas Akhir Praktik Kerja Lapangan (PKL)</strong> sebagai implementasi pembelajaran berbasis industri dalam pengembangan aplikasi manajemen workflow konten.</p>
    <p class="sec-desc">Proyek ini dilaksanakan selama kegiatan PKL di <strong>PT Iccomits</strong>.</p>
    <div class="dev-row">
      <div class="dcard"><div class="dav">A</div><h4>Alya Mutia Zahra</h4><p>Dashboard · Analytics · Report · Settings</p></div>
      <div class="dcard"><div class="dav">R</div><h4>Reysa Anggraeni</h4><p>Brand · Brief · Production · Revision · Approval</p></div>
    </div>
    <div class="school-chip">🏫 SMK Negeri 13 Bandung</div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div><div class="f-logo">PAGE<span>FLOWRY</span></div><p style="margin-top:6px;">Creator Workflow System</p></div>
  <p>© 2026 Academic Project · SMK Negeri 13 Bandung</p>
  <div class="f-links"><a href="#workflow">Workflow</a><a href="#why">Tentang</a><a href="#roles">Roles</a><a href="/login">Login</a></div>
</footer>

<script>
  // Cursor
  const cg = document.getElementById('cg');
  document.addEventListener('mousemove', e => { cg.style.left = e.clientX+'px'; cg.style.top = e.clientY+'px'; });

  // Navbar scroll
  window.addEventListener('scroll', () => {
    document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 40);
  });

  // Scroll reveal
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('vis'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('.rv').forEach(el => ro.observe(el));

  // KPI bars
  const ko = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(e.isIntersecting) e.target.querySelectorAll('.kpi-fi').forEach(b => { b.style.width = b.dataset.w; });
    });
  }, { threshold: 0.3 });
  document.querySelectorAll('.kpi-card').forEach(el => ko.observe(el));

  // Counter
  const co = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(e.isIntersecting) {
        e.target.querySelectorAll('[data-count]').forEach(el => {
          const t = +el.dataset.count; let c = 0;
          const s = Math.ceil(t/40);
          const tmr = setInterval(() => {
            c = Math.min(c+s, t);
            el.textContent = c + (t===100?'%':'+');
            if(c>=t) clearInterval(tmr);
          }, 28);
        });
        co.unobserve(e.target);
      }
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('.hero-stats').forEach(el => co.observe(el));
</script>
</body>
</html>