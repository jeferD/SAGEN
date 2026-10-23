import { Component, signal, inject } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { CommonModule } from '@angular/common';
import { KeycloakService } from './services/keycloak.service';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, CommonModule],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('tesoreria-frontend');
  public keycloakService = inject(KeycloakService);

  public retryLogin(): void {
    window.location.href = window.location.origin + '/admin/inicio';
  }
}
