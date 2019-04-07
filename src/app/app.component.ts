import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { Alert } from './alert';
import { AuthService } from './auth/auth.service';
import { AlertService } from './alert.service';

@Component({
 	selector: 'app-root',
  template: `
    <div class="container">
      <nav class="navbar navbar-default">
        <div class="navbar-header">
          <a class="navbar-brand" routerLink="/dashboard"></a>
        </div>
        <ul class="nav navbar-nav">
          <li>
            <a routerLink="/private" routerLinkActive="active">Private Deals</a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a *ngIf="!authService.isLoggedIn" (click)="authService.login()">Log In</a>
          </li>
          <li>
            <a (click)="authService.logout()" *ngIf="authService.isLoggedIn">Log Out</a>
          </li>
        </ul>
      </nav>
      <div class="col-sm-12">
        <router-outlet></router-outlet>
      </div>
    </div>
  `,
  styles: [
    `.navbar-right { margin-right: 0px !important}`
  ]
})
export class AppComponent {
  alertsSub: Subscription;
  error: any;

  // Note: We haven't implemented the Deal or Auth Services yet.
  constructor(
    public alertService: AlertService,
    public authService: AuthService
  ) { }

}
