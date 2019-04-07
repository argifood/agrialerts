import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { Pref } from '../pref';
import { AuthService } from '../auth/auth.service';
import { PrefsService } from '../prefs.service';

@Component({
  selector: 'app-prefs',
  templateUrl: 'prefs.component.html',
  styleUrls: ['prefs.component.css']
})
export class PrefsComponent implements OnInit {
  prefsSub: Subscription;
	pref: Pref;
  prefs: Pref[];
  error: any;

  constructor(
	public prefsService: PrefsService,
  public authService: AuthService
  ) { }
	
	getPrefData(pref_id) {
    this.prefsSub = this.prefsService
      .getPref(pref_id)
      .subscribe(
        pref => this.pref = pref,
        err => this.error = err
      );
		
	}

  ngOnInit() {
    this.prefsSub = this.prefsService
      .getPrefs()
      .subscribe(
        prefs => this.prefs = prefs,
        err => this.error = err
      );
  }

  ngOnDestroy() {
    this.prefsSub.unsubscribe();
  }

}

