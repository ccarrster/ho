//
//  Person.m
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import "BFPerson.h"
#import "BFSeat.h"
#import "BFLocation.h"

static BFPerson *_instance;

@implementation BFPerson

+ (BFPerson *)sharedInstance {
    if (_instance == nil) {
        _instance = [[BFPerson alloc] init];
    }
    
    return _instance;
}

- (id)init {
    self = [super init];
    if (self) {
        _seat = [[BFSeat alloc] init];
        _location = [[BFLocation alloc] init];
    }
    
    return self;
}

- (UIColor *)colour {
    if (self.seat.seatId == nil) {
        return [UIColor whiteColor];
    } else {
        switch ([self.seat.seatId integerValue] % 5) {
            case 0:
                return [UIColor colorWithRed:247.0/255.0 green:108.0/255.0 blue:180.0/255.0 alpha:1.0];
                break;
                
            case 1:
                return [UIColor colorWithRed:248.0/255.0 green:194.0/255.0 blue:99.0/255.0 alpha:1.0];
                break;
            
            case 2:
                return [UIColor colorWithRed:187.0/255.0 green:240.0/255.0 blue:109.0/255.0 alpha:1.0];
                break;
            
            case 3:
                return [UIColor colorWithRed:182.0/255.0 green:173.0/255.0 blue:228.0/255.0 alpha:1.0];
                break;
            
            case 4:
                return [UIColor colorWithRed:177.0/255.0 green:121.0/255.0 blue:219.0/255.0 alpha:1.0];
                break;
                
            default:
                return [UIColor whiteColor];
                break;
        }
    }
}

@end
