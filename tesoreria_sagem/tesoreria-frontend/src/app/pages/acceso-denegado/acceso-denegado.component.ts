import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-acceso-denegado',
  standalone: true,
  imports: [CommonModule],
  template: `
    <div class="denied-container">
      <div class="denied-card animate-fade-in">
        <!-- Icono de Seguridad -->
        <div class="shield-badge">
          <i class="bi bi-shield-x"></i>
        </div>

        <h2 class="title">Acceso Restringido</h2>
        <p class="subtitle">
          No cuenta con el rol necesario en el token para visualizar este módulo.
        </p>

        <!-- Mensaje de Rol Requerido -->
        <div class="role-requirement-box">
          <div class="req-header">
            <i class="bi bi-key-fill text-amber-500"></i>
            <span>Rol Requerido:</span>
          </div>
          <code class="required-role-pill">sagem-tesoreria</code>
        </div>

        <!-- Información del Usuario Autenticado -->
        <div class="user-details-card" *ngIf="authService.currentUser() as user">
          <div class="detail-row">
            <span class="detail-label">Usuario:</span>
            <span class="detail-value font-semibold">{{ user.name }} ({{ user.username }})</span>
          </div>
          <div class="detail-row" *ngIf="user.email">
            <span class="detail-label">Correo:</span>
            <span class="detail-value">{{ user.email }}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Roles en Token:</span>
            <div class="roles-container">
              @if (user.roles && user.roles.length > 0) {
                <span *ngFor="let r of user.roles" class="role-chip">{{ r }}</span>
              } @else {
                <span class="text-xs text-slate-400 italic">No se detectaron roles en el token</span>
              }
            </div>
          </div>
        </div>

        <p class="instructions">
          Si requiere consultar información de Tesorería, Cartera, Recobros o Impuestos, 
          solicite la asignación del rol <strong>sagem-tesoreria</strong> al administrador de Keycloak / TI de Emssanar.
        </p>

        <!-- Botones de Acción -->
        <div class="actions">
          <button type="button" class="btn btn-primary" (click)="reintentar()">
            <i class="bi bi-arrow-clockwise"></i> Reintentar Verificación
          </button>
          <button type="button" class="btn btn-secondary" (click)="cerrarSesion()">
            <i class="bi bi-box-arrow-right"></i> Salir / Cambiar Cuenta
          </button>
        </div>
      </div>
    </div>
  `,
  styles: [`
    .denied-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #0b1329 0%, #1a2744 100%);
      padding: 24px;
      font-family: inherit;
    }

    .denied-card {
      background: white;
      border-radius: 20px;
      padding: 40px 32px;
      width: 100%;
      max-width: 520px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .shield-badge {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #dc2626;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 38px;
      margin: 0 auto 20px;
      box-shadow: 0 8px 20px rgba(220, 38, 38, 0.2);
    }

    .title {
      font-size: 1.5rem;
      font-weight: 800;
      color: #1e293b;
      margin-bottom: 8px;
    }

    .subtitle {
      font-size: 0.9rem;
      color: #64748b;
      margin-bottom: 24px;
    }

    .role-requirement-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .req-header {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      font-size: 0.85rem;
      color: #334155;
    }

    .required-role-pill {
      background: #dc2626;
      color: white;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 6px;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
    }

    .user-details-card {
      background: #f1f5f9;
      border-radius: 12px;
      padding: 14px 16px;
      text-align: left;
      font-size: 0.82rem;
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .detail-row {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .detail-label {
      color: #64748b;
      font-size: 0.72rem;
      text-transform: uppercase;
      font-weight: 700;
    }

    .detail-value {
      color: #1e293b;
    }

    .roles-container {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
      margin-top: 4px;
    }

    .role-chip {
      background: white;
      border: 1px solid #cbd5e1;
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 0.72rem;
      color: #475569;
    }

    .instructions {
      font-size: 0.8rem;
      color: #64748b;
      line-height: 1.4;
      margin-bottom: 24px;
    }

    .actions {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .btn {
      width: 100%;
      padding: 10px 16px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: pointer;
      border: none;
      transition: all 0.2s ease;
    }

    .btn-primary {
      background: #0284c7;
      color: white;
    }

    .btn-primary:hover {
      background: #0369a1;
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: #f1f5f9;
      color: #475569;
      border: 1px solid #cbd5e1;
    }

    .btn-secondary:hover {
      background: #e2e8f0;
      color: #1e293b;
    }
  `]
})
export class AccesoDenegadoComponent {
  authService = inject(AuthService);
  private router = inject(Router);

  reintentar(): void {
    this.authService.syncFromKeycloak();
    if (this.authService.hasTesoreriaRole()) {
      this.router.navigate(['/admin/inicio']);
    }
  }

  cerrarSesion(): void {
    this.authService.logout();
  }
}
