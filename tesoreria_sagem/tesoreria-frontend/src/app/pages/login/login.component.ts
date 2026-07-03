import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule],
  template: `
    <div class="login-page">
      <div class="login-card animate-fade-in">
        <!-- Logo Section -->
        <div class="login-logo">
          <div class="logo-circle">
            <i class="bi bi-wallet2"></i>
          </div>
          <h2>SAGEM</h2>
          <p>Sistema de Gestión y Tesorería - Emssanar EPS</p>
        </div>

        <!-- Quick Credentials (WOW effect & ease of use) -->
        <div class="quick-roles">
          <span class="quick-label">Acceso Rápido (Simulado):</span>
          <div class="quick-buttons">
            <button class="btn btn-secondary btn-sm" (click)="useCredentials('admin')">
              <i class="bi bi-person-fill-gear"></i> Tesorería (Admin)
            </button>
            <button class="btn btn-secondary btn-sm" (click)="useCredentials('pqrs')">
              <i class="bi bi-chat-left-text"></i> PQRS (Gestor)
            </button>
          </div>
        </div>

        <hr class="divider" />

        <!-- Login Form -->
        <form (ngSubmit)="onSubmit()" #loginForm="ngForm">
          <div class="form-group">
            <label class="form-label" for="username">Usuario</label>
            <div class="input-wrapper">
              <i class="bi bi-person input-icon"></i>
              <input 
                type="text" 
                id="username" 
                name="username" 
                class="form-control" 
                placeholder="Ingrese su usuario" 
                [(ngModel)]="username" 
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="password">Contraseña</label>
            <div class="input-wrapper">
              <i class="bi bi-lock input-icon"></i>
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="••••••••" 
                [(ngModel)]="password" 
                required>
            </div>
          </div>

          <!-- Alert message -->
          <div *ngIf="errorMessage()" class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ errorMessage() }}</span>
          </div>

          <!-- Alert recovery -->
          <div *ngIf="recoveryMessage()" class="alert alert-success">
            <i class="bi bi-envelope-check"></i>
            <span>{{ recoveryMessage() }}</span>
          </div>

          <button type="submit" class="btn btn-primary w-full" [disabled]="!loginForm.form.valid">
            <i class="bi bi-box-arrow-in-right"></i> INGRESAR
          </button>
        </form>

        <!-- Recovery / Footer links -->
        <div class="login-footer">
          <button class="btn-link" (click)="toggleRecovery()">¿Olvidó su contraseña?</button>
          <a href="https://servicios.emssanareps.co/" target="_blank" class="btn-link home-link">
            <i class="bi bi-arrow-left"></i> Regresar a Emssanar
          </a>
        </div>

        <!-- Hidden recovery panel -->
        <div *ngIf="showRecovery()" class="recovery-panel animate-fade-in">
          <div class="recovery-header">
            <h4>Recuperación de Clave</h4>
            <button class="close-btn" (click)="showRecovery.set(false)">&times;</button>
          </div>
          <p>Ingrese su número de documento de identificación registrado para enviarle su contraseña actual.</p>
          <div class="form-group mt-2">
            <input 
              type="text" 
              class="form-control" 
              placeholder="Número de Identificación" 
              [(ngModel)]="recoveryNoId">
          </div>
          <button class="btn btn-primary btn-sm w-full" (click)="handleRecovery()">
            Recuperar
          </button>
        </div>

      </div>
    </div>
  `,
  styles: [`
    .login-page {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--neutral-900) 0%, var(--primary-dark) 100%);
      padding: 20px;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.98);
      border-radius: var(--border-radius-lg);
      padding: 40px 32px;
      width: 100%;
      max-width: 440px;
      box-shadow: var(--shadow-xl);
      border: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
      overflow: hidden;
    }

    .login-logo {
      text-align: center;
      margin-bottom: 24px;
    }

    .logo-circle {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: var(--primary-color);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 28px;
      margin: 0 auto 12px;
      box-shadow: var(--shadow-md);
    }

    .login-logo h2 {
      font-size: 24px;
      color: var(--primary-color);
      letter-spacing: 1px;
      margin-bottom: 4px;
    }

    .login-logo p {
      font-size: 0.85rem;
      color: var(--neutral-500);
    }

    .quick-roles {
      margin-bottom: 16px;
      background-color: var(--neutral-100);
      padding: 12px;
      border-radius: var(--border-radius-sm);
    }

    .quick-label {
      display: block;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--neutral-600);
      margin-bottom: 8px;
      text-transform: uppercase;
    }

    .quick-buttons {
      display: flex;
      gap: 10px;
    }

    .quick-buttons button {
      flex: 1;
      font-size: 0.8rem;
      padding: 8px;
    }

    .divider {
      border: none;
      height: 1px;
      background-color: var(--neutral-200);
      margin: 20px 0;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--neutral-400);
      font-size: 1.1rem;
    }

    .input-wrapper .form-control {
      padding-left: 38px;
    }

    .w-full {
      width: 100%;
    }

    .mt-2 {
      margin-top: 8px;
    }

    .login-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 24px;
      font-size: 0.85rem;
    }

    .btn-link {
      background: none;
      border: none;
      color: var(--primary-color);
      cursor: pointer;
      text-decoration: none;
      font-weight: 500;
      transition: color var(--transition-fast);
    }

    .btn-link:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }

    .home-link {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* Recovery Panel */
    .recovery-panel {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: white;
      padding: 40px 32px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      z-index: 10;
    }

    .recovery-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
      border-bottom: 2px solid var(--primary-light);
      padding-bottom: 8px;
    }

    .recovery-panel p {
      font-size: 0.875rem;
      color: var(--neutral-600);
      margin-bottom: 16px;
    }

    .close-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--neutral-400);
      cursor: pointer;
    }

    .close-btn:hover {
      color: var(--neutral-700);
    }
  `]
})
export class LoginComponent {
  username = '';
  password = '';
  
  recoveryNoId = '';
  showRecovery = signal(false);
  errorMessage = signal<string | null>(null);
  recoveryMessage = signal<string | null>(null);

  constructor(
    private authService: AuthService,
    private router: Router
  ) {
    if (this.authService.isAuthenticated()) {
      const role = this.authService.userRole();
      if (role === 1) {
        this.router.navigate(['/admin/inicio']);
      } else if (role === 2) {
        this.router.navigate(['/pqrs/lista']);
      }
    }
  }

  useCredentials(role: 'admin' | 'pqrs'): void {
    this.username = role;
    this.password = '123456';
    this.errorMessage.set(null);
    this.recoveryMessage.set(null);
  }

  onSubmit(): void {
    this.errorMessage.set(null);
    this.recoveryMessage.set(null);

    const success = this.authService.login(this.username, this.password);
    if (success) {
      const role = this.authService.userRole();
      if (role === 1) {
        this.router.navigate(['/admin/inicio']);
      } else if (role === 2) {
        this.router.navigate(['/pqrs/lista']);
      }
    } else {
      this.errorMessage.set('Usuario o contraseña incorrectos.');
    }
  }

  toggleRecovery(): void {
    this.showRecovery.set(true);
    this.recoveryNoId = '';
    this.errorMessage.set(null);
    this.recoveryMessage.set(null);
  }

  handleRecovery(): void {
    this.errorMessage.set(null);
    this.recoveryMessage.set(null);

    if (!this.recoveryNoId.trim()) {
      this.errorMessage.set('Por favor, ingrese un número de identificación.');
      return;
    }

    const email = this.authService.recuperarClave(this.recoveryNoId.trim());
    if (email) {
      this.recoveryMessage.set(`Clave enviada al correo registrado: ${email}`);
      setTimeout(() => {
        this.showRecovery.set(false);
      }, 3000);
    } else {
      this.errorMessage.set('El número de identificación no se encuentra registrado.');
    }
  }
}
