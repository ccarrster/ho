//
//  BFPressView.m
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import "BFPressView.h"

@interface BFPressView ()

@property (nonatomic, strong) NSTimer *growTimer;
@property (nonatomic, strong) NSTimer *shrinkTimer;
@property (nonatomic, strong) UITouch *touch;
@property (nonatomic, strong) UIView *circleView;
@property (nonatomic) NSInteger numTimerFirings;
@property (nonatomic) BOOL touched;

@end

@implementation BFPressView

- (id)initWithFrame:(CGRect)frame {
    self = [super initWithFrame:frame];
    if (self) {
        self.backgroundColor = [UIColor blackColor];
    }
    
    return self;
}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event {
    if (self.shrinkTimer != nil && self.shrinkTimer.valid) {
        return; // ignore new touches while shrinking
    }
    
    self.touch = [touches anyObject];
    self.circleView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 0, 0)];
    self.circleView.backgroundColor = self.pressColour;
    [self addSubview:self.circleView];
    
    self.numTimerFirings = 0;
    self.growTimer = [NSTimer scheduledTimerWithTimeInterval:0.01 target:self selector:@selector(growCircle) userInfo:nil repeats:YES];
    
    if (self.delegate != nil) {
        [self.delegate pressViewWasPressed:self];
    }
}

- (void)touchesMoved:(NSSet *)touches withEvent:(UIEvent *)event {
    
}

- (void)touchesEnded:(NSSet *)touches withEvent:(UIEvent *)event {
    [self endTouch];
}

- (void)touchesCancelled:(NSSet *)touches withEvent:(UIEvent *)event {
    [self endTouch];
}

- (void)endTouch {
    [self.growTimer invalidate];
    
    self.shrinkTimer = [NSTimer scheduledTimerWithTimeInterval:0.01 target:self selector:@selector(shrinkCircle) userInfo:nil repeats:YES];
    
    if (self.delegate != nil) {
        [self.delegate pressViewWasReleased:self];
    }
}

- (void)growCircle {
    self.numTimerFirings++;
    
    CGPoint origin = self.circleView.frame.origin;
    CGSize size = self.circleView.frame.size;
    
    self.circleView.frame = CGRectMake(origin.x, origin.y, size.width + (self.numTimerFirings), size.height + (self.numTimerFirings));
    CGPoint touchPoint = [self.touch locationInView:self];

    self.circleView.center = touchPoint;
    self.circleView.layer.cornerRadius = self.circleView.frame.size.width / 2;
    
    [self setNeedsDisplay];
}

- (void)shrinkCircle {
    self.numTimerFirings--;
    
    CGPoint origin = self.circleView.frame.origin;
    CGSize size = self.circleView.frame.size;
    
    CGFloat newCircumference = MIN(size.width - (self.numTimerFirings), 0.0);
    
    self.circleView.frame = CGRectMake(origin.x, origin.y, newCircumference, newCircumference);
    CGPoint touchPoint = [self.touch locationInView:self];

    self.circleView.center = touchPoint;
    self.circleView.layer.cornerRadius = self.circleView.frame.size.width / 2;
    
    if (newCircumference <= 0) {
        [self.shrinkTimer invalidate];
    }
    
    [self setNeedsDisplay];
}

@end
