import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { Ob } from './ob';
import { Obdim } from './obdim';
import { AuthService } from '../auth/auth.service';
import { ObService } from '../ob.service';

@Component({
  selector: 'app-obs',
  templateUrl: 'obs.component.html',
  styleUrls: ['obs.component.css']
})
export class ObsComponent implements OnInit {
  obsSub: Subscription;
  ob: Ob;
  obs: Ob[];
  obdim: Obdim;
  obdims: Obdim[];
  error: any;

  constructor(
	public obService: ObService,
	public authService: AuthService
  ) { }
	
	getObsData(pref_id) {
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

