import { TestBed } from '@angular/core/testing';

import { ObServiceService } from './ob-service.service';

describe('ObServiceService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ObServiceService = TestBed.get(ObServiceService);
    expect(service).toBeTruthy();
  });
});
