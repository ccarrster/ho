//
//  ViewController.m
//  be--from
//
//  Created by Matt Charters on 2015-05-23.
//  Copyright (c) 2015 be--from. All rights reserved.
//

#import <CoreLocation/CoreLocation.h>

#import "BFViewController.h"
#import "BFPerson.h"
#import "BFLocation.h"
#import "BFSeat.h"
#import "BFPressView.h"

typedef NS_ENUM(NSInteger, BFViewState) {
    BFViewStateBe,
    BFViewStateFrom,
    BFViewStateGo
};

@interface BFViewController () <CLLocationManagerDelegate, BFPressViewDelegate>

@property (nonatomic) BFViewState state;
@property (nonatomic, strong) CLLocationManager *locationManager;
@property (nonatomic, strong) MKPointAnnotation *selectedLocation;
@property (nonatomic) BOOL zoomedMap;

@end

@implementation BFViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    
    self.locationManager = [[CLLocationManager alloc] init];
    self.locationManager.delegate = self;
    
    self.state = BFViewStateBe;
    self.mapView.hidden = YES;
    self.zoomedMap = NO;
    self.inputButton.hidden = YES;
    
    UILongPressGestureRecognizer *pressRecognizer = [[UILongPressGestureRecognizer alloc] initWithTarget:self action:@selector(handleLongPress:)];
    pressRecognizer.minimumPressDuration = 1.0;
    [self.mapView addGestureRecognizer:pressRecognizer];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    if (textField.text.length > 0) {
        // get the seat id and transition to the next view
        [BFPerson sharedInstance].seat.seatId = textField.text;
        self.state = BFViewStateFrom;
        
        [textField resignFirstResponder];
        return NO;
    }
    
    return YES;
}

- (void)setState:(BFViewState)state {
    if (_state != state) {
        
        switch (state) {
            case BFViewStateBe:
                self.questionLabel.text = @"Where will you be?";
                self.inputField.hidden = NO;
                self.inputButton.hidden = YES;
                
                break;
                
            case BFViewStateFrom:
                self.questionLabel.text = @"Where are you from?";
                self.inputField.hidden = YES;
                self.inputButton.hidden = NO;
                self.view.backgroundColor = [BFPerson sharedInstance].colour;
                
                break;
                
            case BFViewStateGo:
            {
                self.mapView.hidden = YES;
                self.inputField.hidden = YES;
                self.inputButton.hidden = YES;
                self.questionLabel.hidden = YES;
                BFPressView *pressView = [[BFPressView alloc] initWithFrame:self.view.bounds];
                pressView.pressColour = [BFPerson sharedInstance].colour;
                pressView.delegate = self;
                [self.view addSubview:pressView];
            }
                
            default:
                break;
        }
        
        _state = state;
    }
}

- (IBAction)inputButtonTapped:(id)sender {
    [self.locationManager requestWhenInUseAuthorization];
    self.mapView.showsUserLocation = YES;
    self.mapView.hidden = NO;
}

- (MKAnnotationView *)mapView:(MKMapView *)mapView viewForAnnotation:(id<MKAnnotation>)annotation
{
    if ([annotation isKindOfClass:[MKUserLocation class]])
        return nil;
    
    MKPinAnnotationView *annotationView = [[MKPinAnnotationView alloc] initWithAnnotation:annotation reuseIdentifier:@"DroppedPin"];
    
    annotationView.draggable = YES;
    annotationView.canShowCallout = YES;
    annotationView.animatesDrop = YES;
    annotationView.rightCalloutAccessoryView = [UIButton buttonWithType:UIButtonTypeDetailDisclosure];
    
    return annotationView;
}

- (void)mapView:(MKMapView *)mapView annotationView:(MKAnnotationView *)view calloutAccessoryControlTapped:(UIControl *)control {
    if (control == view.rightCalloutAccessoryView) {
        // select the location
        [BFPerson sharedInstance].location.coordinate = view.annotation.coordinate;
        
        self.state = BFViewStateGo;
    }
}

- (void)mapView:(MKMapView *)mapView didUpdateUserLocation:(MKUserLocation *)userLocation {
    if (!self.zoomedMap) {
        MKCoordinateRegion region = MKCoordinateRegionMakeWithDistance(userLocation.coordinate, 5000, 5000);
        [self.mapView setRegion:[self.mapView regionThatFits:region] animated:YES];
        
        self.zoomedMap = YES;
    }
}

- (void)handleLongPress:(UIGestureRecognizer *)gestureRecognizer {
    if (gestureRecognizer.state != UIGestureRecognizerStateBegan) {
        return;
    }
    
    if (self.selectedLocation != nil) {
        [self.mapView removeAnnotation:self.selectedLocation];
    }
    
    CGPoint touchPoint = [gestureRecognizer locationInView:self.mapView];
    CLLocationCoordinate2D touchMapCoordinate = [self.mapView convertPoint:touchPoint toCoordinateFromView:self.mapView];
    
    self.selectedLocation = [[MKPointAnnotation alloc] init];
    self.selectedLocation.coordinate = touchMapCoordinate;
    self.selectedLocation.title = @"This is where I'm from.";
    [self.mapView addAnnotation:self.selectedLocation];
    [self.mapView selectAnnotation:self.selectedLocation animated:YES];
}

- (void)pressViewWasPressed:(BFPressView *)pressView {
    [BFPerson sharedInstance].seat.enabled = YES;
}

- (void)pressViewWasReleased:(BFPressView *)pressView {
    [BFPerson sharedInstance].seat.enabled = NO;
}

@end
