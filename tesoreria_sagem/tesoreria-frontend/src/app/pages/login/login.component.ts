import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule],
  template: `
    <div class="login-redirect-page">
      <div class="redirect-card animate-fade-in">
        <div class="logo-circle">
          <i class="bi bi-wallet2"></i>
        </div>
        <h2>SAGEM</h2>
        <p class="subtitle">Sistema de Gestión y Tesorería - Emssanar EPS</p>

        <div class="spinner-container">
          <div class="spinner"></div>
        </div>

        <p class="status-msg">Redirigiendo al portal corporativo de Keycloak SSO...</p>

        <button type="button" class="btn btn-keycloak" (click)="irAKeycloak()">
          <i class="bi bi-box-arrow-in-right"></i>
          Ingresar con Keycloak
        </button>
      </div>
    </div>
  `,
  styles: [`
    .login-redirect-page {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #0b1329 0%, #1a2744 100%);
      padding: 20px;
      font-family: inherit;
    }

    .redirect-card {
      background: white;
      border-radius: 20px;
      padding: 44px 36px;
      width: 100%;
      max-width: 440px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .logo-circle {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: #004b9a;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 30px;
      margin: 0 auto 16px;
      box-shadow: 0 6px 16px rgba(0, 75, 154, 0.25);
    }

    h2 {
      font-size: 1.6rem;
      font-weight: 800;
      color: #004b9a;
      letter-spacing: 1px;
      margin-bottom: 4px;
    }

    .subtitle {
      font-size: 0.85rem;
      color: #64748b;
      margin-bottom: 28px;
    }

    .spinner-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }

    .spinner {
      width: 44px;
      height: 44px;
      border: 4px solid #e2e8f0;
      border-top-color: #004b9a;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .status-msg {
      font-size: 0.9rem;
      color: #334155;
      font-weight: 500;
      margin-bottom: 24px;
    }

    .btn-keycloak {
      width: 100%;
      padding: 12px 20px;
      background: linear-gradient(135deg, #0d6efd 0%, #004b9a 100%);
      color: white;
      font-weight: 700;
      font-size: 0.95rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.2s ease;
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    }

    .btn-keycloak:hover {
      background: linear-gradient(135deg, #0b5ed7 0%, #003770 100%);
      transform: translateY(-1px);
    }
  `]
})
export class LoginComponent implements OnInit {
  private authService = inject(AuthService);
  private router = inject(Router);

  ngOnInit(): void {
    if (this.authService.isAuthenticated()) {
      if (this.authService.hasTesoreriaRole()) {
        this.router.navigate(['/admin/inicio']);
      } else {
        this.router.navigate(['/acceso-denegado']);
      }
      return;
    }

    // Redirigir de forma automática al SSO de Keycloak
    this.irAKeycloak();
  }

  irAKeycloak(): void {
    this.authService.loginWithKeycloak();
  }
}
