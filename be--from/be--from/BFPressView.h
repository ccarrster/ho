//
//  BFPressView.h
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol BFPressViewDelegate;

@interface BFPressView : UIView

@property (strong, nonatomic) UIColor *pressColour;
@property (weak, nonatomic) id<BFPressViewDelegate> delegate;

@end

@protocol BFPressViewDelegate <NSObject>

- (void)pressViewWasPressed:(BFPressView *)pressView;
- (void)pressViewWasReleased:(BFPressView *)pressView;

@end