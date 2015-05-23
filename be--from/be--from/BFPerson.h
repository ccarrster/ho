//
//  Person.h
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>

@class BFSeat;
@class BFLocation;

@interface BFPerson : NSObject

@property (strong, nonatomic) BFSeat *seat;
@property (strong, nonatomic) BFLocation *location;

+ (BFPerson *)sharedInstance;

- (UIColor *)colour;

@end
