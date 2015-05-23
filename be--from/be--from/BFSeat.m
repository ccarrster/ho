//
//  Seat.m
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import "BFSeat.h"

@implementation BFSeat

- (void)setSeatId:(NSString *)seatId {
    _seatId = seatId;
    self.enabled = NO;
}

- (void)setEnabled:(BOOL)enabled {
    _enabled = enabled;
    
    NSString *urlString = [NSString stringWithFormat:@"http://104.236.89.130/ho/index.php?action=setseat&seat=%@&enabled=%@", self.seatId, (self.enabled ? @"1" : @"0")];
    NSURL *enabledURL = [[NSURL alloc] initWithString:urlString];
    NSURLRequest *request = [NSURLRequest requestWithURL:enabledURL];
    
    [NSURLConnection sendAsynchronousRequest:request
                                       queue:[NSOperationQueue mainQueue]
                           completionHandler:^(NSURLResponse *response, NSData *data, NSError *connectionError) {
                               NSLog(@"Request should be completed now");
                           }];
}

@end
