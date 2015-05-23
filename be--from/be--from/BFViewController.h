//
//  ViewController.h
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>

@interface BFViewController : UIViewController <UITextFieldDelegate, MKMapViewDelegate>

@property (weak, nonatomic) IBOutlet UILabel *questionLabel;
@property (weak, nonatomic) IBOutlet UITextField *inputField;
@property (weak, nonatomic) IBOutlet UIButton *inputButton;
@property (weak, nonatomic) IBOutlet MKMapView *mapView;

- (IBAction)inputButtonTapped:(id)sender;

@end

