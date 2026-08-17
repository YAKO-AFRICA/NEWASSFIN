@extends('layouts.main')

@section('content')

<style>
:root {
    --jeko-ink: #12232e;
    --jeko-slate: #4a5c68;
    --jeko-mist: #eef2f4;
    --jeko-line: #dde4e8;
    --jeko-paper: #ffffff;
    --jeko-success: #1f7a4d;
    --jeko-success-bg: #e8f5ee;
    --jeko-error: #b3382c;
    --jeko-error-bg: #fbeae7;
    --jeko-pending: #a4720a;
    --jeko-pending-bg: #fbf1de;
    --jeko-accent: #2a5f74;
    --jeko-radius: 10px;
    --jeko-font-display: 'Fraunces', Georgia, 'Times New Roman', serif;
    --jeko-font-body: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    --jeko-font-mono: 'JetBrains Mono', 'SFMono-Regular', Consolas, monospace;
}

@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

#jeko-dashboard {
    background: var(--jeko-mist);
    font-family: var(--jeko-font-body), 'Inter', sans-serif;
    color: var(--jeko-ink);
    min-height: 100vh;
    padding: 2rem 0 3rem;
}

#jeko-dashboard * { box-sizing: border-box; }

.jeko-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 1.25rem;
    margin-bottom: 2rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid var(--jeko-line);
}

.jeko-eyebrow {
    font-size: 0.72rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--jeko-slate);
    font-weight: 600;
    margin-bottom: 0.35rem;
}

.jeko-title {
    font-family: var(--jeko-font-display), serif;
    font-size: 2.1rem;
    font-weight: 600;
    line-height: 1.1;
    margin: 0;
    color: var(--jeko-ink);
}

.jeko-title .dot { color: var(--jeko-accent); }

/* Filter bar */
.jeko-filters {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
}

.jeko-filters input[type="date"] {
    background: var(--jeko-paper);
    border: 1px solid var(--jeko-line);
    border-radius: 7px;
    padding: 0.5rem 0.7rem;
    font-size: 0.85rem;
    color: var(--jeko-ink);
    font-family: var(--jeko-font-mono);
    transition: border-color .15s ease;
}
.jeko-filters input[type="date"]:focus {
    outline: none;
    border-color: var(--jeko-accent);
    box-shadow: 0 0 0 3px rgba(42,95,116,0.12);
}

.jeko-btn {
    border: 1px solid transparent;
    border-radius: 7px;
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}
.jeko-btn-primary {
    background: var(--jeko-ink);
    color: #fff;
}
.jeko-btn-primary:hover { background: #0a1620; }
.jeko-btn-ghost {
    background: transparent;
    border-color: var(--jeko-line);
    color: var(--jeko-slate);
}
.jeko-btn-ghost:hover { border-color: var(--jeko-slate); color: var(--jeko-ink); }

.jeko-period-group {
    display: inline-flex;
    background: var(--jeko-paper);
    border: 1px solid var(--jeko-line);
    border-radius: 7px;
    padding: 2px;
}
.jeko-period-group button {
    border: none;
    background: transparent;
    padding: 0.4rem 0.75rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--jeko-slate);
    border-radius: 5px;
    cursor: pointer;
    transition: all .15s ease;
    font-family: var(--jeko-font-mono);
}
.jeko-period-group button.active {
    background: var(--jeko-ink);
    color: #fff;
}

/* KPI grid */
.jeko-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: var(--jeko-line);
    border: 1px solid var(--jeko-line);
    border-radius: var(--jeko-radius);
    overflow: hidden;
    margin-bottom: 1.25rem;
}
@media (max-width: 992px) { .jeko-kpi-grid { grid-template-columns: repeat(2, 1fr); } }

.jeko-kpi {
    background: var(--jeko-paper);
    padding: 1.25rem 1.4rem;
    position: relative;
    transition: background .15s ease;
}
.jeko-kpi:hover { background: #fbfcfc; }

.jeko-kpi-label {
    font-size: 0.74rem;
    color: var(--jeko-slate);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}
.jeko-kpi-value {
    font-family: var(--jeko-font-display), serif;
    font-size: 1.9rem;
    font-weight: 600;
    line-height: 1;
    color: var(--jeko-ink);
    min-height: 2rem;
    display: flex;
    align-items: center;
}
.jeko-kpi-sub {
    font-size: 0.76rem;
    color: var(--jeko-slate);
    margin-top: 0.4rem;
    font-family: var(--jeko-font-mono);
}
.jeko-kpi.is-success .jeko-kpi-value { color: var(--jeko-success); }
.jeko-kpi.is-error .jeko-kpi-value { color: var(--jeko-error); }
.jeko-kpi.is-pending .jeko-kpi-value { color: var(--jeko-pending); }
.jeko-kpi-bar {
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
}
.jeko-kpi.is-success .jeko-kpi-bar { background: var(--jeko-success); }
.jeko-kpi.is-error .jeko-kpi-bar { background: var(--jeko-error); }
.jeko-kpi.is-pending .jeko-kpi-bar { background: var(--jeko-pending); }
.jeko-kpi.is-neutral .jeko-kpi-bar { background: var(--jeko-accent); }

.jeko-secondary-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--jeko-line);
    border: 1px solid var(--jeko-line);
    border-radius: var(--jeko-radius);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
@media (max-width: 992px) { .jeko-secondary-grid { grid-template-columns: 1fr; } }

/* Cards */
.jeko-card {
    background: var(--jeko-paper);
    border: 1px solid var(--jeko-line);
    border-radius: var(--jeko-radius);
    margin-bottom: 1.5rem;
    overflow: hidden;
}
.jeko-card-header {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid var(--jeko-line);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.6rem;
}
.jeko-card-header h4 {
    font-family: var(--jeko-font-display), serif;
    font-size: 1.05rem;
    font-weight: 600;
    margin: 0;
    color: var(--jeko-ink);
}
.jeko-card-body { padding: 1.4rem; }

.jeko-badge {
    font-family: var(--jeko-font-mono);
    font-size: 0.72rem;
    font-weight: 500;
    padding: 0.2rem 0.55rem;
    border-radius: 20px;
    background: var(--jeko-mist);
    color: var(--jeko-slate);
    border: 1px solid var(--jeko-line);
}

.jeko-charts-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 0;
}
@media (max-width: 992px) { .jeko-charts-row { grid-template-columns: 1fr; } }
.jeko-charts-row .jeko-card { margin-bottom: 0; }
.jeko-row-spacer { height: 1.5rem; }

.chart-wrap { position: relative; height: 280px; }
.chart-wrap.tall { height: 320px; }

/* Table */
.jeko-table-wrap { overflow-x: auto; }
table.jeko-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}
table.jeko-table thead th {
    text-align: left;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--jeko-slate);
    font-weight: 600;
    padding: 0.6rem 0.9rem;
    border-bottom: 1px solid var(--jeko-line);
    white-space: nowrap;
    position: sticky;
    top: 0;
    background: var(--jeko-paper);
}
table.jeko-table tbody td {
    padding: 0.65rem 0.9rem;
    border-bottom: 1px solid var(--jeko-mist);
    color: var(--jeko-ink);
    vertical-align: middle;
}
table.jeko-table tbody tr {
    transition: background .12s ease;
}
table.jeko-table tbody tr:hover { background: var(--jeko-mist); }
table.jeko-table tbody tr.row-anomalie { background: var(--jeko-error-bg); }
table.jeko-table tbody tr.row-anomalie:hover { background: #f6d9d3; }
table.jeko-table code {
    font-family: var(--jeko-font-mono);
    font-size: 0.78rem;
    background: var(--jeko-mist);
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
}
.cell-amount { font-family: var(--jeko-font-mono); font-weight: 600; }

.pill {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.22rem 0.6rem;
    border-radius: 20px;
}
.pill-success { background: var(--jeko-success-bg); color: var(--jeko-success); }
.pill-error { background: var(--jeko-error-bg); color: var(--jeko-error); }
.pill-pending { background: var(--jeko-pending-bg); color: var(--jeko-pending); }
.pill-neutral { background: var(--jeko-mist); color: var(--jeko-slate); }
.pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

.jeko-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--jeko-slate);
}
.jeko-empty-icon { font-size: 1.6rem; margin-bottom: 0.5rem; opacity: 0.5; }

/* Skeleton loading */
.jeko-skel {
    display: inline-block;
    width: 70px;
    height: 1.5rem;
    background: linear-gradient(90deg, var(--jeko-mist) 25%, #e2e8eb 37%, var(--jeko-mist) 63%);
    background-size: 400% 100%;
    border-radius: 4px;
    animation: jeko-shimmer 1.4s ease infinite;
}
@keyframes jeko-shimmer {
    0% { background-position: 100% 50%; }
    100% { background-position: 0 50%; }
}

.jeko-fade-in { animation: jeko-fade 0.35s ease both; }
@keyframes jeko-fade { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

.jeko-toast {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    background: var(--jeko-ink);
    color: #fff;
    padding: 0.8rem 1.2rem;
    border-radius: 8px;
    font-size: 0.85rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    z-index: 1000;
    opacity: 0;
    transform: translateY(8px);
    transition: all .25s ease;
    pointer-events: none;
}
.jeko-toast.show { opacity: 1; transform: translateY(0); }

@media (prefers-reduced-motion: reduce) {
    #jeko-dashboard *, .jeko-kpi, .jeko-fade-in, .jeko-toast { animation: none !important; transition: none !important; }
}

.jeko-btn:focus-visible, .jeko-period-group button:focus-visible, .jeko-filters input:focus-visible {
    outline: 2px solid var(--jeko-accent);
    outline-offset: 2px;
}
</style>

<div id="jeko-dashboard">
<div class="container-fluid">

    <div class="jeko-header">
        <div>
            <div class="jeko-eyebrow">Paiements mobiles &middot; YAKO Africa</div>
            <h1 class="jeko-title">Tableau de bord JEKO<span class="dot">.</span></h1>
        </div>
        <form id="filtre-dates" class="jeko-filters" autocomplete="off">
            <div class="jeko-period-group" id="period-shortcuts">
                <button type="button" data-period="7">7j</button>
                <button type="button" data-period="15">15j</button>
                <button type="button" data-period="30" class="active">30j</button>
            </div>
            <input type="date" name="date_debut" id="date_debut" value="{{ now()->subDays(30)->toDateString() }}">
            <span style="color: var(--jeko-slate); font-size: 0.8rem;">&rarr;</span>
            <input type="date" name="date_fin" id="date_fin" value="{{ now()->toDateString() }}">
            <button type="submit" class="jeko-btn jeko-btn-primary">Filtrer</button>
            <button type="button" class="jeko-btn jeko-btn-ghost" id="btn-export-csv">Exporter CSV</button>
        </form>
    </div>

    <!-- KPI principaux -->
    <div class="jeko-kpi-grid" id="kpi-cards">
        <div class="jeko-kpi is-neutral">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">Total paiements</div>
            <div class="jeko-kpi-value" id="kpi-paiements"><span class="jeko-skel"></span></div>
        </div>
        <div class="jeko-kpi is-success">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">Succès</div>
            <div class="jeko-kpi-value" id="kpi-succes"><span class="jeko-skel"></span></div>
            <div class="jeko-kpi-sub" id="kpi-taux-succes">&mdash;</div>
        </div>
        <div class="jeko-kpi is-error">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">Échecs</div>
            <div class="jeko-kpi-value" id="kpi-echec"><span class="jeko-skel"></span></div>
        </div>
        <div class="jeko-kpi is-pending">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">En attente</div>
            <div class="jeko-kpi-value" id="kpi-attente"><span class="jeko-skel"></span></div>
        </div>
    </div>

    <div class="jeko-secondary-grid">
        <div class="jeko-kpi is-neutral">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">Propositions avec paiement</div>
            <div class="jeko-kpi-value" id="kpi-propositions"><span class="jeko-skel"></span></div>
        </div>
        <div class="jeko-kpi is-neutral">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">Succès migrés vers le métier</div>
            <div class="jeko-kpi-value" id="kpi-migres"><span class="jeko-skel"></span></div>
            <div class="jeko-kpi-sub" id="kpi-taux-migration">&mdash;</div>
        </div>
        <div class="jeko-kpi is-neutral">
            <div class="jeko-kpi-bar"></div>
            <div class="jeko-kpi-label">Montant total succès</div>
            <div class="jeko-kpi-value" id="kpi-montant" style="font-size:1.5rem;"><span class="jeko-skel"></span></div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="jeko-charts-row">
        <div class="jeko-card">
            <div class="jeko-card-header">
                <h4>Répartition par statut</h4>
                <span class="jeko-badge" id="statut-total">&mdash;</span>
            </div>
            <div class="jeko-card-body">
                <div class="chart-wrap"><canvas id="chartStatuts"></canvas></div>
            </div>
        </div>
        <div class="jeko-card">
            <div class="jeko-card-header">
                <h4>Répartition par opérateur</h4>
                <span class="jeko-badge">Wave &middot; Orange &middot; Moov &middot; MTN &middot; Djamo</span>
            </div>
            <div class="jeko-card-body">
                <div class="chart-wrap"><canvas id="chartOperateurs"></canvas></div>
            </div>
        </div>
    </div>

    <div class="jeko-row-spacer"></div>

    <div class="jeko-card">
        <div class="jeko-card-header">
            <h4>Évolution journalière des paiements</h4>
        </div>
        <div class="jeko-card-body">
            <div class="chart-wrap tall"><canvas id="chartEvolution"></canvas></div>
        </div>
    </div>

    <!-- Table migration -->
    <div class="jeko-card">
        <div class="jeko-card-header">
            <h4>Suivi migration &rarr; système métier</h4>
            <span class="jeko-badge" id="migration-count">&mdash;</span>
        </div>
        <div class="jeko-card-body" style="padding: 0;">
            <div class="jeko-table-wrap">
                <table class="jeko-table" id="table-migration">
                    <thead>
                        <tr>
                            <th>Réf. paiement</th>
                            <th>Proposition</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Migration</th>
                            <th>Contrat</th>
                            <th>Étape</th>
                            <th>Conseiller </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>

<div class="jeko-toast" id="jeko-toast"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const CHART_COLORS = ['#2a5f74', '#c98a3e', '#7a5c99', '#3f8f6f', '#b3382c'];
    const STATUT_LABELS = { success: 'Succès', error: 'Échec', pending: 'En attente' };
    const STATUT_COLORS = { success: '#1f7a4d', error: '#b3382c', pending: '#a4720a' };

    let chartStatuts, chartOperateurs, chartEvolution;
    let currentData = null;

    const fmtNum = n => new Intl.NumberFormat('fr-FR').format(n ?? 0);
    const fmtFcfa = n => fmtNum(n) + ' FCFA';
    const fmtDate = d => d ? new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short' }) : '—';

    function toast(message) {
        const el = document.getElementById('jeko-toast');
        el.textContent = message;
        el.classList.add('show');
        setTimeout(() => el.classList.remove('show'), 2800);
    }

    function setSkeletons() {
        document.querySelectorAll('.jeko-kpi-value').forEach(el => {
            el.innerHTML = '<span class="jeko-skel"></span>';
        });
    }

    async function chargerDashboard() {
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        if (!dateDebut || !dateFin) { toast('Sélectionnez une période valide'); return; }

        setSkeletons();

        try {
            const response = await fetch(`{{ route('jeko.dashboard.data') }}?date_debut=${dateDebut}&date_fin=${dateFin}`);
            if (!response.ok) throw new Error(`Erreur HTTP ${response.status}`);
            const data = await response.json();
            currentData = data;

            updateKPIs(data.kpis);
            updateStatutChart(data.repartition_statuts);
            updateOperateurChart(data.repartition_operateur);
            updateEvolutionChart(data.evolution_journaliere);
            updateMigrationTable(data.migration);
        } catch (err) {
            toast('Erreur de chargement : ' + err.message);
            document.querySelectorAll('.jeko-kpi-value').forEach(el => el.textContent = '—');
        }
    }

    function updateKPIs(kpis) {
        const set = (id, val) => { document.getElementById(id).textContent = val; document.getElementById(id).classList.add('jeko-fade-in'); };
        set('kpi-paiements', fmtNum(kpis.total_paiements));
        set('kpi-succes', fmtNum(kpis.paiements_succes));
        document.getElementById('kpi-taux-succes').textContent = `${kpis.taux_succes_pct}% du total`;
        set('kpi-echec', fmtNum(kpis.paiements_echec));
        set('kpi-attente', fmtNum(kpis.paiements_en_attente));
        set('kpi-propositions', fmtNum(kpis.propositions_avec_paiement));
        set('kpi-migres', fmtNum(kpis.paiements_succes_migres));
        document.getElementById('kpi-taux-migration').textContent = `${kpis.taux_migration_pct}% des succès migrés`;
        set('kpi-montant', fmtFcfa(kpis.montant_total_succes));
    }

    function updateStatutChart(statuts) {
        const labels = statuts.map(s => STATUT_LABELS[s.payment_status] || s.payment_status);
        const values = statuts.map(s => s.nb);
        const colors = statuts.map(s => STATUT_COLORS[s.payment_status] || '#6c757d');
        const total = values.reduce((a, b) => a + b, 0);
        document.getElementById('statut-total').textContent = `${fmtNum(total)} paiements`;

        if (chartStatuts) chartStatuts.destroy();
        chartStatuts = new Chart(document.getElementById('chartStatuts'), {
            type: 'doughnut',
            data: { labels, datasets: [{ data: values, backgroundColor: colors, borderWidth: 3, borderColor: '#fff', hoverOffset: 6 }] },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '68%',
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 16, font: { size: 12, family: 'Inter' } } },
                    tooltip: { callbacks: { label: ctx => `${ctx.label}: ${fmtNum(ctx.raw)} (${(ctx.raw/total*100).toFixed(1)}%)` } } },
                animation: { duration: 500, easing: 'easeOutQuart' }
            }
        });
    }

    function updateOperateurChart(operateurs) {
        const labels = Object.keys(operateurs);
        const values = labels.map(op => operateurs[op].reduce((s, r) => s + r.nb, 0));

        if (chartOperateurs) chartOperateurs.destroy();
        chartOperateurs = new Chart(document.getElementById('chartOperateurs'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Paiements', data: values, backgroundColor: CHART_COLORS, borderRadius: 6, maxBarThickness: 44 }] },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => `${fmtNum(ctx.raw)} paiements` } } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef2f4' } },
                    x: { grid: { display: false } }
                },
                animation: { duration: 500, easing: 'easeOutQuart' }
            }
        });
    }

    function updateEvolutionChart(evolution) {
        const jours = Object.keys(evolution).sort();
        const byStatus = (status) => jours.map(j => (evolution[j].find(r => r.payment_status === status) || {}).nb || 0);

        if (chartEvolution) chartEvolution.destroy();
        chartEvolution = new Chart(document.getElementById('chartEvolution'), {
            type: 'line',
            data: {
                labels: jours.map(fmtDate),
                datasets: [
                    { label: 'Succès', data: byStatus('success'), borderColor: STATUT_COLORS.success, backgroundColor: 'rgba(31,122,77,0.08)', fill: true, tension: 0.35, pointRadius: 2, pointHoverRadius: 5 },
                    { label: 'Échec', data: byStatus('error'), borderColor: STATUT_COLORS.error, backgroundColor: 'rgba(179,56,44,0.06)', fill: true, tension: 0.35, pointRadius: 2, pointHoverRadius: 5 },
                    { label: 'En attente', data: byStatus('pending'), borderColor: STATUT_COLORS.pending, backgroundColor: 'rgba(164,114,10,0.06)', fill: true, tension: 0.35, pointRadius: 2, pointHoverRadius: 5 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, font: { size: 12, family: 'Inter' } } } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef2f4' } },
                    x: { grid: { display: false } }
                },
                animation: { duration: 500, easing: 'easeOutQuart' }
            }
        });
    }

    function etapeLabel(etape) {
        const map = { 1: 'En saisie', 2: 'Transmise', 3: 'Acceptée & migrée', 4: 'Rejetée' };
        return map[etape] || null;
    }

    function updateMigrationTable(rows) {
        const tbody = document.querySelector('#table-migration tbody');
        document.getElementById('migration-count').textContent = `${fmtNum(rows.length)} lignes`;
        tbody.innerHTML = '';

        if (rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7"><div class="jeko-empty">
                <div class="jeko-empty-icon">&#128203;</div>
                Aucun paiement sur cette période
            </div></td></tr>`;
            return;
        }

        rows.forEach(row => {
            const etape = etapeLabel(row.etape_contrat);
            const agent = row.agent
            ? `${row.agent.nom_complet ?? `${row.agent.prenom ?? ''} ${row.agent.nom ?? ''}`.trim()}
               ${row.agent.codeagent ? `(${row.agent.codeagent})` : ''}`
            : '—';
            tbody.innerHTML += `
                <tr class="${row.anomalie ? 'row-anomalie' : ''}">
                    <td><code>${row.codePaiement ?? row.idPaiment}</code></td>
                    <td>${row.idproposition ?? '—'}</td>
                    <td class="cell-amount">${fmtFcfa(row.montant)}</td>
                    <td>${fmtDate(row.datepaiement)}</td>
                    <td>${row.estMigre
                        ? `<span class="pill pill-success"><span class="pill-dot"></span>Migré</span>`
                        : `<span class="pill pill-pending"><span class="pill-dot"></span>Non migré</span>`}</td>
                    <td>${row.contrat_trouve
                        ? `<span class="pill pill-success"><span class="pill-dot"></span>Trouvé</span>`
                        : `<span class="pill pill-error"><span class="pill-dot"></span>Introuvable</span>`}</td>
                    <td>${etape ? `<span class="pill pill-neutral">${etape}</span>` : '—'}</td>
                    <td> ${agent} </td>
                    
                </tr>`;
        });
    }

    function exportToCSV() {
        if (!currentData?.migration?.length) { toast('Aucune donnée à exporter'); return; }
        const headers = ['Réf. paiement', 'Proposition', 'Montant', 'Date', 'Migré', 'Contrat trouvé', 'Étape'];
        const rows = currentData.migration.map(r => [
            r.codePaiement ?? r.idPaiment, r.idproposition ?? '', r.montant, r.datepaiement ?? '',
            r.estMigre ? 'Oui' : 'Non', r.contrat_trouve ? 'Oui' : 'Non', etapeLabel(r.etape_contrat) ?? ''
        ]);
        const csv = [headers.join(','), ...rows.map(r => r.map(v => `"${v}"`).join(','))].join('\n');
        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `dashboard_jeko_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(link); link.click(); document.body.removeChild(link);
        toast('Export CSV téléchargé');
    }

    document.getElementById('filtre-dates').addEventListener('submit', e => { e.preventDefault(); chargerDashboard(); });
    document.getElementById('btn-export-csv').addEventListener('click', exportToCSV);

    document.querySelectorAll('#period-shortcuts [data-period]').forEach(btn => {
        btn.addEventListener('click', function() {
            const days = parseInt(this.dataset.period);
            const now = new Date();
            const start = new Date(now);
            start.setDate(now.getDate() - days);
            document.getElementById('date_debut').value = start.toISOString().split('T')[0];
            document.getElementById('date_fin').value = now.toISOString().split('T')[0];
            document.querySelectorAll('#period-shortcuts [data-period]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            chargerDashboard();
        });
    });

    chargerDashboard();
});
</script>
@endsection