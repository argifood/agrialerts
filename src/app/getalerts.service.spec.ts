import { TestBed } from '@angular/core/testing';

import { GetalertsService } from './getalerts.service';

describe('GetalertsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: GetalertsService = TestBed.get(GetalertsService);
    expect(service).toBeTruthy();
  });
});
