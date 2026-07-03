import { Component, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MockDataService, CubosGraficoRecord, CubosIndicadorRecord } from '../../services/mock-data.service';

@Component({
  selector: 'app-dashboard-cubos',
  standalone: true,
  imports: [CommonModule],
  template: `
    <div class="cubos-container animate-fade-in">
      
      <!-- Top Overview Summary Cards -->
      <div class="metrics-grid">
        <div class="metric-card card">
          <div class="metric-icon primary">
            <i class="bi bi-bank"></i>
          </div>
          <div class="metric-details">
            <h4>$ 45.674 M</h4>
            <p>Total Cartera EPS</p>
          </div>
        </div>

        <div class="metric-card card">
          <div class="metric-icon success">
            <i class="bi bi-wallet-fill"></i>
          </div>
          <div class="metric-details">
            <h4>$ 44.708 M</h4>
            <p>Total Cartera IPS</p>
          </div>
        </div>

        <div class="metric-card card">
          <div class="metric-icon danger">
            <i class="bi bi-arrow-down-up"></i>
          </div>
          <div class="metric-details">
            <h4>$ 965 M</h4>
            <p>Diferencia Global</p>
          </div>
        </div>

        <div class="metric-card card">
          <div class="metric-icon warning">
            <i class="bi bi-percent"></i>
          </div>
          <div class="metric-details">
            <h4>97.8%</h4>
            <p>Coincidencia Promedio</p>
          </div>
        </div>
      </div>

      <!-- Main Visualizations Grid -->
      <div class="visuals-grid">
        
        <!-- Bar Chart (Resumen Gerencial - circular 030) -->
        <div class="chart-panel card">
          <div class="card-title">
            <span><i class="bi bi-graph-up"></i> Cartera Reportada Circular 030 (Corte: 2020-12-31)</span>
            <span class="badge badge-success">EPS vs IPS</span>
          </div>

          <div class="chart-wrapper">
            <!-- Custom Dynamic SVG Bar Chart -->
            <svg viewBox="0 0 600 320" class="svg-chart">
              <!-- Y-Axis Grid Lines & Labels -->
              <g class="grid-lines">
                <line x1="60" y1="40" x2="560" y2="40" stroke="#e2e8f0" stroke-dasharray="4" />
                <line x1="60" y1="100" x2="560" y2="100" stroke="#e2e8f0" stroke-dasharray="4" />
                <line x1="60" y1="160" x2="560" y2="160" stroke="#e2e8f0" stroke-dasharray="4" />
                <line x1="60" y1="220" x2="560" y2="220" stroke="#e2e8f0" stroke-dasharray="4" />
                <line x1="60" y1="260" x2="560" y2="260" stroke="#cbd5e1" />
                
                <text x="50" y="45" text-anchor="end" class="chart-text">16B</text>
                <text x="50" y="105" text-anchor="end" class="chart-text">12B</text>
                <text x="50" y="165" text-anchor="end" class="chart-text">8B</text>
                <text x="50" y="225" text-anchor="end" class="chart-text">4B</text>
                <text x="50" y="265" text-anchor="end" class="chart-text">0</text>
              </g>

              <!-- Dynamic Bars -->
              <g *ngFor="let bar of chartBars(); let i = index">
                <!-- Bar rect -->
                <rect 
                  [attr.x]="60 + (i * 80) + 15" 
                  [attr.y]="260 - bar.height" 
                  width="40" 
                  [attr.height]="bar.height" 
                  [attr.fill]="bar.color"
                  class="chart-bar-rect"
                  rx="4"
                />
                
                <!-- Value tag on hover -->
                <text 
                  [attr.x]="60 + (i * 80) + 35" 
                  [attr.y]="260 - bar.height - 8" 
                  text-anchor="middle" 
                  class="bar-val-text">
                  {{ bar.valueText }}
                </text>

                <!-- X Axis label -->
                <text 
                  [attr.x]="60 + (i * 80) + 35" 
                  y="280" 
                  text-anchor="middle" 
                  class="chart-text bar-lbl-text">
                  {{ bar.shortName }}
                </text>
              </g>
            </svg>
          </div>
          
          <div class="chart-legend">
            <div *ngFor="let bar of chartBars()" class="legend-item">
              <span class="legend-dot" [style.background-color]="bar.color"></span>
              <span class="legend-name">{{ bar.name }}: <b>{{ bar.valueFormatted }}</b></span>
            </div>
          </div>
        </div>

        <!-- Indicator Table (Resumen Prestador) -->
        <div class="table-panel card">
          <div class="card-title">
            <span><i class="bi bi-file-earmark-diff"></i> Coincidencia de Saldos Reportados</span>
          </div>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Fecha Corte</th>
                  <th>EPS</th>
                  <th>Saldo EPS</th>
                  <th>Saldo IPS</th>
                  <th>Diferencia</th>
                  <th>Nivel Coincidencia</th>
                </tr>
              </thead>
              <tbody>
                <tr *ngFor="let item of indicators()">
                  <td>{{ item.fecha_corte }}</td>
                  <td class="font-medium">{{ item.nomeps }}</td>
                  <td class="text-right">{{ item.vrsaldoeps }}</td>
                  <td class="text-right">{{ item.vrsaldoips }}</td>
                  <td class="text-right text-danger font-semibold">{{ item.diferencia }}</td>
                  <td>
                    <span class="badge" [class]="getCoincidenceBadge(item.nivel)">
                      {{ item.nivel }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>
  `,
  styles: [`
    .cubos-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .metric-card {
      margin-bottom: 0;
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 20px;
    }

    .metric-icon {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.4rem;
    }

    .metric-icon.primary { background-color: var(--primary-light); color: var(--primary-color); }
    .metric-icon.success { background-color: var(--success-light); color: var(--success-color); }
    .metric-icon.danger { background-color: var(--danger-light); color: var(--danger-color); }
    .metric-icon.warning { background-color: var(--warning-light); color: var(--warning-hover); }

    .metric-details h4 {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--neutral-800);
      margin-bottom: 2px;
    }

    .metric-details p {
      font-size: 0.75rem;
      color: var(--neutral-400);
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    /* Layout Visuals */
    .visuals-grid {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .chart-panel {
      flex: 1;
    }

    .table-panel {
      flex: 1;
    }

    .chart-wrapper {
      padding: 16px;
      background: var(--neutral-50);
      border-radius: var(--border-radius-sm);
      border: 1px solid var(--neutral-200);
      display: flex;
      justify-content: center;
    }

    .svg-chart {
      width: 100%;
      max-width: 600px;
      height: auto;
    }

    .chart-text {
      font-size: 10px;
      fill: var(--neutral-500);
      font-weight: 500;
    }

    .chart-bar-rect {
      cursor: pointer;
      transition: fill var(--transition-fast), transform var(--transition-fast);
      transform-origin: bottom;
    }

    .chart-bar-rect:hover {
      opacity: 0.85;
      transform: scaleY(1.02);
    }

    .bar-val-text {
      font-size: 9px;
      fill: var(--neutral-700);
      font-weight: 600;
      opacity: 0;
      transition: opacity var(--transition-fast);
    }

    /* Show value on hovering the bar group */
    g:hover .bar-val-text {
      opacity: 1;
    }

    .bar-lbl-text {
      font-weight: 600;
    }

    .chart-legend {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 12px;
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px solid var(--neutral-200);
    }

    .legend-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .legend-dot {
      width: 12px;
      height: 12px;
      border-radius: 3px;
    }

    .legend-name {
      font-size: 0.8rem;
      color: var(--neutral-600);
    }

    .font-medium {
      font-weight: 500;
      color: var(--neutral-800);
    }

    .text-right {
      text-align: right;
    }

    .text-danger {
      color: var(--danger-color);
    }

    .getCoincidenceBadge {
      font-weight: 600;
    }
  `]
})
export class DashboardCubosComponent {
  chartData = signal<CubosGraficoRecord[]>([]);
  indicators = signal<CubosIndicadorRecord[]>([]);

  // Color scheme for premium chart bars
  private barColors = [
    '#2F62B0', // Emssanar
    '#3b82f6', // Asmet
    '#10b981', // Coosalud
    '#f59e0b', // Nueva EPS
    '#6366f1', // Mallamas
    '#ef4444'  // Comparta
  ];

  // Map values to heights and coordinates for the SVG chart
  chartBars = computed(() => {
    const rawData = this.chartData();
    if (rawData.length === 0) return [];

    // Find max value to normalize bar heights to a max height of 180px
    const maxVal = Math.max(...rawData.map(d => d.y));
    const maxBarHeight = 180;

    return rawData.map((d, index) => {
      const height = (d.y / maxVal) * maxBarHeight;
      const shortName = d.name.split(' ')[0]; // E.g. "EMSSANAR"
      const valueFormatted = `$ ${d.y.toLocaleString('es-CO')}`;
      const valueText = `${(d.y / 1e9).toFixed(1)}B`; // e.g. "15.3B"
      
      return {
        name: d.name,
        shortName: shortName,
        value: d.y,
        valueFormatted: valueFormatted,
        valueText: valueText,
        height: height,
        color: this.barColors[index % this.barColors.length]
      };
    });
  });

  constructor(private mockService: MockDataService) {
    this.chartData.set(this.mockService.getCubosGrafica());
    this.indicators.set(this.mockService.getCubosIndicadores());
  }

  getCoincidenceBadge(level: string): string {
    if (level.includes('ALTO')) return 'badge-success';
    if (level.includes('MEDIO')) return 'badge-warning';
    return 'badge-danger';
  }
}
