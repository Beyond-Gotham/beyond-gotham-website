<?php
/**
 * Template Name: InfoTerminal Live Demo
 * Description: Interaktive OSINT-Plattform Showcase mit Live-Graph-Visualisierung
 * 
 * @package BeyondGotham
 * @version 1.0.0
 */

get_header(); ?>

<main id="infoterminal-live" class="page-infoterminal" style="
    padding:0;
    background:var(--bg-darker, #0a0a0a);
    color:var(--fg, #e0e0e0);
    min-height:100vh;
">

    <!-- Hero Section mit Live-Status -->
    <section class="infoterminal-hero" style="
        padding:80px 0 60px;
        background:linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-bottom:3px solid var(--accent, #00d4ff);
    ">
        <div class="container" style="max-width:1400px;margin:0 auto;padding:0 24px;">
            <div style="display:grid;grid-template-columns:1fr auto;gap:40px;align-items:center;">
                
                <!-- Titel & Beschreibung -->
                <div>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="3"/>
                            <line x1="12" y1="2" x2="12" y2="6"/>
                            <line x1="12" y1="18" x2="12" y2="22"/>
                            <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/>
                            <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/>
                        </svg>
                        <span style="
                            font-size:0.9rem;
                            color:var(--accent, #00d4ff);
                            font-weight:600;
                            letter-spacing:0.05em;
                            text-transform:uppercase;
                        ">OSINT Intelligence Platform</span>
                    </div>
                    
                    <h1 style="
                        margin:0 0 20px;
                        font-size:clamp(2.5rem, 5vw, 4rem);
                        line-height:1.1;
                        font-weight:800;
                        background:linear-gradient(135deg, #fff 0%, var(--accent, #00d4ff) 100%);
                        -webkit-background-clip:text;
                        -webkit-text-fill-color:transparent;
                        background-clip:text;
                    ">
                        InfoTerminal Live
                    </h1>
                    
                    <p style="
                        margin:0 0 32px;
                        font-size:1.3rem;
                        color:var(--muted, #a0a0a0);
                        max-width:600px;
                        line-height:1.6;
                    ">
                        Erlebe unsere OSINT-Analyseplattform in Echtzeit. Visualisiere komplexe Netzwerke, 
                        analysiere Datenströme und erkunde interaktive Graphen – direkt in deinem Browser.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        <a href="#live-demo" class="btn-primary" style="
                            display:inline-flex;
                            align-items:center;
                            gap:8px;
                            padding:14px 32px;
                            background:var(--accent, #00d4ff);
                            color:#000;
                            border:none;
                            border-radius:8px;
                            font-weight:600;
                            text-decoration:none;
                            transition:all 0.3s ease;
                            box-shadow:0 4px 20px rgba(0, 212, 255, 0.3);
                        " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 25px rgba(0, 212, 255, 0.5)';" 
                           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(0, 212, 255, 0.3)';">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="5 3 19 12 5 21 5 3"/>
                            </svg>
                            Demo starten
                        </a>
                        
                        <a href="#features" class="btn-secondary" style="
                            display:inline-flex;
                            align-items:center;
                            gap:8px;
                            padding:14px 32px;
                            background:transparent;
                            color:var(--fg, #e0e0e0);
                            border:2px solid rgba(255,255,255,0.2);
                            border-radius:8px;
                            font-weight:600;
                            text-decoration:none;
                            transition:all 0.3s ease;
                        " onmouseover="this.style.borderColor='var(--accent, #00d4ff)';this.style.color='var(--accent, #00d4ff)';" 
                           onmouseout="this.style.borderColor='rgba(255,255,255,0.2)';this.style.color='var(--fg, #e0e0e0)';">
                            Features entdecken
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Live Status Card -->
                <div class="status-card" style="
                    background:rgba(255,255,255,0.05);
                    backdrop-filter:blur(10px);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:16px;
                    padding:24px;
                    min-width:280px;
                ">
                    <h3 style="
                        margin:0 0 20px;
                        font-size:1.1rem;
                        font-weight:600;
                        color:var(--accent, #00d4ff);
                    ">Plattform Status</h3>
                    
                    <div class="status-items" style="display:flex;flex-direction:column;gap:12px;">
                        <?php
                        $services = [
                            ['name' => 'API Gateway', 'status' => 'online', 'latency' => '23ms'],
                            ['name' => 'Neo4j Database', 'status' => 'online', 'latency' => '15ms'],
                            ['name' => 'Query Engine', 'status' => 'online', 'latency' => '31ms'],
                            ['name' => 'Graph Renderer', 'status' => 'online', 'latency' => '18ms'],
                        ];
                        
                        foreach ($services as $service):
                            $dot_color = $service['status'] === 'online' ? '#00ff88' : '#ff4444';
                        ?>
                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            padding:8px 12px;
                            background:rgba(0,0,0,0.3);
                            border-radius:8px;
                        ">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="
                                    width:8px;
                                    height:8px;
                                    border-radius:50%;
                                    background:<?php echo $dot_color; ?>;
                                    box-shadow:0 0 8px <?php echo $dot_color; ?>;
                                    animation:pulse 2s infinite;
                                "></div>
                                <span style="font-size:0.9rem;color:var(--fg, #e0e0e0);">
                                    <?php echo esc_html($service['name']); ?>
                                </span>
                            </div>
                            <span style="font-size:0.85rem;color:var(--muted, #a0a0a0);">
                                <?php echo esc_html($service['latency']); ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.1);">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.85rem;color:var(--muted, #a0a0a0);">Uptime</span>
                            <span style="font-size:0.9rem;color:#00ff88;font-weight:600;">99.97%</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Live Demo Section -->
    <section id="live-demo" class="demo-section" style="padding:80px 0;background:var(--bg, #0f0f0f);">
        <div class="container" style="max-width:1600px;margin:0 auto;padding:0 24px;">
            
            <div style="text-align:center;margin-bottom:60px;">
                <h2 style="
                    margin:0 0 16px;
                    font-size:clamp(2rem, 4vw, 3rem);
                    font-weight:700;
                ">Interaktive Graph-Visualisierung</h2>
                <p style="
                    margin:0;
                    font-size:1.2rem;
                    color:var(--muted, #a0a0a0);
                    max-width:700px;
                    margin:0 auto;
                ">
                    Erkunde Beziehungen, analysiere Muster und visualisiere komplexe Netzwerke 
                    mit unserem Neo4j-basierten Graph-Browser.
                </p>
            </div>
            
            <!-- Demo Tabs -->
            <div class="demo-tabs" style="
                display:flex;
                gap:12px;
                margin-bottom:24px;
                border-bottom:2px solid rgba(255,255,255,0.1);
                padding-bottom:16px;
            ">
                <button class="demo-tab active" onclick="switchDemo('graph')" style="
                    padding:12px 24px;
                    background:var(--accent, #00d4ff);
                    color:#000;
                    border:none;
                    border-radius:8px 8px 0 0;
                    font-weight:600;
                    cursor:pointer;
                    transition:all 0.3s ease;
                ">
                    Graph Browser
                </button>
                <button class="demo-tab" onclick="switchDemo('query')" style="
                    padding:12px 24px;
                    background:rgba(255,255,255,0.05);
                    color:var(--fg, #e0e0e0);
                    border:none;
                    border-radius:8px 8px 0 0;
                    font-weight:600;
                    cursor:pointer;
                    transition:all 0.3s ease;
                ">
                    Query Editor
                </button>
                <button class="demo-tab" onclick="switchDemo('analysis')" style="
                    padding:12px 24px;
                    background:rgba(255,255,255,0.05);
                    color:var(--fg, #e0e0e0);
                    border:none;
                    border-radius:8px 8px 0 0;
                    font-weight:600;
                    cursor:pointer;
                    transition:all 0.3s ease;
                ">
                    Analyse Tools
                </button>
            </div>
            
            <!-- Demo Content -->
            <div class="demo-content" style="
                background:rgba(0,0,0,0.5);
                border:1px solid rgba(255,255,255,0.1);
                border-radius:16px;
                overflow:hidden;
                box-shadow:0 20px 60px rgba(0,0,0,0.5);
            ">
                
                <!-- Graph Browser Demo -->
                <div id="demo-graph" class="demo-panel" style="display:block;min-height:600px;">
                    <div style="
                        background:linear-gradient(135deg, #1a1a2e 0%, #0f0f1e 100%);
                        padding:40px;
                        text-align:center;
                        height:600px;
                        display:flex;
                        flex-direction:column;
                        justify-content:center;
                        align-items:center;
                    ">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--accent, #00d4ff)" stroke-width="1.5" style="margin-bottom:24px;">
                            <circle cx="12" cy="12" r="3"/>
                            <circle cx="6" cy="6" r="2"/>
                            <circle cx="18" cy="6" r="2"/>
                            <circle cx="6" cy="18" r="2"/>
                            <circle cx="18" cy="18" r="2"/>
                            <line x1="9" y1="12" x2="6" y2="8"/>
                            <line x1="15" y1="12" x2="18" y2="8"/>
                            <line x1="9" y1="12" x2="6" y2="16"/>
                            <line x1="15" y1="12" x2="18" y2="16"/>
                        </svg>
                        <h3 style="margin:0 0 16px;font-size:1.8rem;font-weight:700;">
                            Neo4j Graph Visualisierung
                        </h3>
                        <p style="margin:0 0 32px;color:var(--muted, #a0a0a0);max-width:500px;">
                            In der vollständigen Demo würde hier der Neo4j Browser eingebettet werden, 
                            mit dem Sie interaktiv Graphen erkunden können.
                        </p>
                        
                        <!-- Beispiel-Queries -->
                        <div style="
                            background:rgba(0,0,0,0.5);
                            border:1px solid rgba(0, 212, 255, 0.3);
                            border-radius:12px;
                            padding:24px;
                            text-align:left;
                            max-width:600px;
                        ">
                            <h4 style="margin:0 0 16px;color:var(--accent, #00d4ff);font-size:1.1rem;">
                                Beispiel-Queries zum Ausprobieren:
                            </h4>
                            <code style="
                                display:block;
                                background:rgba(0,0,0,0.8);
                                padding:12px;
                                border-radius:6px;
                                color:#00ff88;
                                font-family:monospace;
                                font-size:0.9rem;
                                margin-bottom:12px;
                            ">MATCH (n) RETURN n LIMIT 25</code>
                            <code style="
                                display:block;
                                background:rgba(0,0,0,0.8);
                                padding:12px;
                                border-radius:6px;
                                color:#00ff88;
                                font-family:monospace;
                                font-size:0.9rem;
                                margin-bottom:12px;
                            ">MATCH (p:Person)-[r:KNOWS]->(f:Person) RETURN p, r, f</code>
                            <code style="
                                display:block;
                                background:rgba(0,0,0,0.8);
                                padding:12px;
                                border-radius:6px;
                                color:#00ff88;
                                font-family:monospace;
                                font-size:0.9rem;
                            ">MATCH path = shortestPath((a)-[*]-(b)) RETURN path</code>
                        </div>
                    </div>
                </div>
                
                <!-- Query Editor Demo -->
                <div id="demo-query" class="demo-panel" style="display:none;min-height:600px;">
                    <div style="padding:40px;">
                        <h3 style="margin:0 0 24px;font-size:1.5rem;">Cypher Query Editor</h3>
                        <p style="color:var(--muted, #a0a0a0);margin-bottom:24px;">
                            Schreiben und testen Sie Cypher-Queries direkt im Browser.
                        </p>
                        <!-- Query Editor Platzhalter -->
                        <div style="
                            background:rgba(0,0,0,0.8);
                            border:1px solid rgba(255,255,255,0.1);
                            border-radius:8px;
                            padding:20px;
                            font-family:monospace;
                            min-height:400px;
                        ">
                            <span style="color:#888;">// Query Editor würde hier implementiert werden</span>
                        </div>
                    </div>
                </div>
                
                <!-- Analysis Tools Demo -->
                <div id="demo-analysis" class="demo-panel" style="display:none;min-height:600px;">
                    <div style="padding:40px;">
                        <h3 style="margin:0 0 24px;font-size:1.5rem;">Analyse-Werkzeuge</h3>
                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">
                            <?php
                            $tools = [
                                ['icon' => '🔍', 'name' => 'Pattern Detection', 'desc' => 'Automatische Mustererkennung in Netzwerken'],
                                ['icon' => '📊', 'name' => 'Graph Statistics', 'desc' => 'Detaillierte Statistiken und Metriken'],
                                ['icon' => '🎯', 'name' => 'Pathfinding', 'desc' => 'Kürzeste Wege und Verbindungen'],
                                ['icon' => '🔗', 'name' => 'Community Detection', 'desc' => 'Cluster und Gruppen identifizieren'],
                            ];
                            foreach ($tools as $tool):
                            ?>
                            <div style="
                                background:rgba(255,255,255,0.03);
                                border:1px solid rgba(255,255,255,0.1);
                                border-radius:12px;
                                padding:24px;
                            ">
                                <div style="font-size:2rem;margin-bottom:12px;"><?php echo $tool['icon']; ?></div>
                                <h4 style="margin:0 0 8px;font-size:1.1rem;"><?php echo esc_html($tool['name']); ?></h4>
                                <p style="margin:0;color:var(--muted, #a0a0a0);font-size:0.9rem;">
                                    <?php echo esc_html($tool['desc']); ?>
                                </p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section" style="
        padding:80px 0;
        background:linear-gradient(180deg, var(--bg, #0f0f0f) 0%, #1a1a2e 100%);
    ">
        <div class="container" style="max-width:1400px;margin:0 auto;padding:0 24px;">
            
            <div style="text-align:center;margin-bottom:60px;">
                <h2 style="
                    margin:0 0 16px;
                    font-size:clamp(2rem, 4vw, 3rem);
                    font-weight:700;
                ">Plattform-Features</h2>
                <p style="
                    margin:0;
                    font-size:1.2rem;
                    color:var(--muted, #a0a0a0);
                    max-width:700px;
                    margin:0 auto;
                ">
                    Professionelle OSINT-Tools für investigative Recherchen und Datenanalyse
                </p>
            </div>
            
            <div class="features-grid" style="
                display:grid;
                grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));
                gap:32px;
            ">
                
                <?php
                $features = [
                    [
                        'icon' => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
                        'title' => 'Multi-Source Intelligence',
                        'desc' => 'Integriere und analysiere Daten aus verschiedenen OSINT-Quellen in einer einheitlichen Plattform.'
                    ],
                    [
                        'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                        'title' => 'Real-Time Processing',
                        'desc' => 'Verarbeite und visualisiere Datenströme in Echtzeit mit minimaler Latenz und hoher Performance.'
                    ],
                    [
                        'icon' => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',
                        'title' => 'Graph Database',
                        'desc' => 'Neo4j-basierte Graphdatenbank für komplexe Beziehungsanalysen und Netzwerk-Visualisierungen.'
                    ],
                    [
                        'icon' => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
                        'title' => 'API-First Architecture',
                        'desc' => 'RESTful und GraphQL APIs für nahtlose Integration in bestehende Workflows und Tools.'
                    ],
                    [
                        'icon' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
                        'title' => 'Security & Privacy',
                        'desc' => 'End-to-End-Verschlüsselung, GDPR-konform und sichere Datenverarbeitung nach höchsten Standards.'
                    ],
                    [
                        'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
                        'title' => 'Cost-Effective',
                        'desc' => 'Open-Source-Komponenten und optimierte Infrastruktur für maximale Kosteneffizienz.'
                    ],
                ];
                
                foreach ($features as $feature):
                ?>
                <div class="feature-card" style="
                    background:rgba(255,255,255,0.02);
                    backdrop-filter:blur(10px);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:16px;
                    padding:32px;
                    transition:all 0.3s ease;
                " onmouseover="this.style.background='rgba(0, 212, 255, 0.05)';this.style.borderColor='rgba(0, 212, 255, 0.3)';this.style.transform='translateY(-4px)';" 
                   onmouseout="this.style.background='rgba(255,255,255,0.02)';this.style.borderColor='rgba(255,255,255,0.1)';this.style.transform='translateY(0)';">
                    
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent, #00d4ff)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:20px;">
                        <?php echo $feature['icon']; ?>
                    </svg>
                    
                    <h3 style="
                        margin:0 0 12px;
                        font-size:1.3rem;
                        font-weight:600;
                    "><?php echo esc_html($feature['title']); ?></h3>
                    
                    <p style="
                        margin:0;
                        color:var(--muted, #a0a0a0);
                        line-height:1.6;
                    "><?php echo esc_html($feature['desc']); ?></p>
                </div>
                <?php endforeach; ?>
                
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section class="tech-stack" style="padding:80px 0;background:var(--bg, #0f0f0f);">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            
            <div style="text-align:center;margin-bottom:60px;">
                <h2 style="margin:0 0 16px;font-size:clamp(2rem, 4vw, 3rem);font-weight:700;">
                    Technologie-Stack
                </h2>
                <p style="margin:0;font-size:1.2rem;color:var(--muted, #a0a0a0);">
                    Moderne, skalierbare und bewährte Technologien
                </p>
            </div>
            
            <div style="
                display:grid;
                grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));
                gap:24px;
            ">
                <?php
                $tech = [
                    ['name' => 'Neo4j', 'type' => 'Database'],
                    ['name' => 'Python', 'type' => 'Backend'],
                    ['name' => 'FastAPI', 'type' => 'API Framework'],
                    ['name' => 'React', 'type' => 'Frontend'],
                    ['name' => 'TypeScript', 'type' => 'Language'],
                    ['name' => 'Docker', 'type' => 'Container'],
                    ['name' => 'Kubernetes', 'type' => 'Orchestration'],
                    ['name' => 'Redis', 'type' => 'Cache'],
                ];
                
                foreach ($tech as $t):
                ?>
                <div style="
                    background:rgba(255,255,255,0.02);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:12px;
                    padding:24px;
                    text-align:center;
                    transition:all 0.3s ease;
                " onmouseover="this.style.background='rgba(255,255,255,0.05)';" 
                   onmouseout="this.style.background='rgba(255,255,255,0.02)';">
                    <h4 style="margin:0 0 8px;font-size:1.1rem;font-weight:600;">
                        <?php echo esc_html($t['name']); ?>
                    </h4>
                    <p style="margin:0;font-size:0.85rem;color:var(--muted, #a0a0a0);">
                        <?php echo esc_html($t['type']); ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
            
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" style="
        padding:100px 0;
        background:linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        position:relative;
        overflow:hidden;
    ">
        <!-- Animated Background -->
        <div style="
            position:absolute;
            top:0;
            left:0;
            right:0;
            bottom:0;
            opacity:0.1;
            background:url('data:image/svg+xml,%3Csvg width=&quot;100&quot; height=&quot;100&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Ccircle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;40&quot; stroke=&quot;%2300d4ff&quot; stroke-width=&quot;1&quot; fill=&quot;none&quot;/%3E%3C/svg%3E');
        "></div>
        
        <div class="container" style="max-width:900px;margin:0 auto;padding:0 24px;text-align:center;position:relative;">
            <h2 style="
                margin:0 0 24px;
                font-size:clamp(2rem, 4vw, 3rem);
                font-weight:800;
                background:linear-gradient(135deg, #fff 0%, var(--accent, #00d4ff) 100%);
                -webkit-background-clip:text;
                -webkit-text-fill-color:transparent;
                background-clip:text;
            ">
                Bereit für professionelle OSINT-Analysen?
            </h2>
            
            <p style="
                margin:0 0 40px;
                font-size:1.3rem;
                color:var(--muted, #a0a0a0);
                max-width:700px;
                margin-left:auto;
                margin-right:auto;
            ">
                Lerne in unseren Kursen, wie du InfoTerminal und andere OSINT-Tools 
                professionell einsetzt. Perfekt für Journalisten, Ermittler und Analysten.
            </p>
            
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/kurse')); ?>" style="
                    display:inline-flex;
                    align-items:center;
                    gap:8px;
                    padding:16px 40px;
                    background:var(--accent, #00d4ff);
                    color:#000;
                    border:none;
                    border-radius:8px;
                    font-weight:600;
                    font-size:1.1rem;
                    text-decoration:none;
                    transition:all 0.3s ease;
                    box-shadow:0 4px 20px rgba(0, 212, 255, 0.3);
                " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 25px rgba(0, 212, 255, 0.5)';" 
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(0, 212, 255, 0.3)';">
                    Kurse ansehen
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
                
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" style="
                    display:inline-flex;
                    align-items:center;
                    gap:8px;
                    padding:16px 40px;
                    background:transparent;
                    color:var(--fg, #e0e0e0);
                    border:2px solid rgba(255,255,255,0.2);
                    border-radius:8px;
                    font-weight:600;
                    font-size:1.1rem;
                    text-decoration:none;
                    transition:all 0.3s ease;
                " onmouseover="this.style.borderColor='var(--accent, #00d4ff)';this.style.color='var(--accent, #00d4ff)';" 
                   onmouseout="this.style.borderColor='rgba(255,255,255,0.2)';this.style.color='var(--fg, #e0e0e0)';">
                    Kontakt aufnehmen
                </a>
            </div>
        </div>
    </section>

</main>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.demo-tab:hover {
    background: rgba(0, 212, 255, 0.2) !important;
    color: var(--accent, #00d4ff) !important;
}

.demo-tab.active {
    background: var(--accent, #00d4ff) !important;
    color: #000 !important;
}
</style>

<script>
function switchDemo(demo) {
    // Hide all panels
    document.querySelectorAll('.demo-panel').forEach(panel => {
        panel.style.display = 'none';
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.demo-tab').forEach(tab => {
        tab.classList.remove('active');
        tab.style.background = 'rgba(255,255,255,0.05)';
        tab.style.color = 'var(--fg, #e0e0e0)';
    });
    
    // Show selected panel
    document.getElementById('demo-' + demo).style.display = 'block';
    
    // Add active class to clicked tab
    event.target.classList.add('active');
    event.target.style.background = 'var(--accent, #00d4ff)';
    event.target.style.color = '#000';
}

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

<?php get_footer(); ?>
